<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Batch;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Exception;

class StockService
{
    /**
     * Registrar entrada de stock
     */
    public function registerIncomingStock(Product $product, Warehouse $warehouse, $quantity, $costPrice, $data = [])
    {
        if (!$product->track_stock) {
            throw new Exception("Product does not track stock");
        }

        return DB::transaction(function () use ($product, $warehouse, $quantity, $costPrice, $data) {
            $batch = null;
            
            // Se o produto controla lotes, criar/atualizar lote
            if ($product->expiry_control) {
                $batch = Batch::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'warehouse_id' => $warehouse->id,
                        'batch_number' => $data['batch_number'] ?? 'BATCH-' . now()->format('YmdHis')
                    ],
                    [
                        'expiry_date' => $data['expiry_date'] ?? null,
                        'production_date' => $data['production_date'] ?? now(),
                        'quantity' => DB::raw("quantity + $quantity"),
                        'cost_price' => $costPrice,
                        'selling_price' => $data['selling_price'] ?? $costPrice * 1.3 // 30% markup
                    ]
                );
            } else {
                // Atualizar stock sem controle de lote
                $batch = Batch::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'warehouse_id' => $warehouse->id,
                        'batch_number' => 'DEFAULT'
                    ],
                    [
                        'quantity' => $quantity,
                        'cost_price' => $costPrice,
                        'selling_price' => $data['selling_price'] ?? $costPrice * 1.3
                    ]
                );
                
                if (!$batch->wasRecentlyCreated) {
                    $batch->increment('quantity', $quantity);
                    $batch->update(['cost_price' => $costPrice]);
                }
            }

            // Registrar movimento de stock
            $movement = StockMovement::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'batch_id' => $batch->id,
                'quantity' => $quantity,
                'type' => 'IN',
                'movement_type' => $data['movement_type'] ?? 'PURCHASE',
                'reference_id' => $data['reference_id'] ?? null,
                'reference_type' => $data['reference_type'] ?? null,
                'notes' => $data['notes'] ?? null,
                'user_id' => auth()->id()
            ]);

            return [
                'batch' => $batch,
                'movement' => $movement
            ];
        });
    }

    /**
     * Registrar saída de stock conforme política FIFO/LIFO
     */
    public function registerOutgoingStock(Product $product, Warehouse $warehouse, $quantity, $data = [])
    {
        if (!$product->track_stock) {
            return null; // Serviços não têm movimento de stock
        }

        if ($product->stock_quantity < $quantity) {
            throw new Exception("Insufficient stock");
        }

        return DB::transaction(function () use ($product, $warehouse, $quantity, $data) {
            $remainingQuantity = $quantity;
            $batchesConsumed = [];
            $movements = [];

            // Obter lotes conforme política de picking
            $query = Batch::where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->where('quantity', '>', 0);

            if ($product->expiry_control) {
                if ($product->stock_policy === 'FIFO') {
                    $query->orderBy('production_date', 'asc');
                } elseif ($product->stock_policy === 'LIFO') {
                    $query->orderBy('production_date', 'desc');
                } elseif ($product->stock_policy === 'FEFO') {
                    $query->orderBy('expiry_date', 'asc');
                }
            }

            $batches = $query->get();

            foreach ($batches as $batch) {
                if ($remainingQuantity <= 0) break;

                $consumed = min($batch->quantity, $remainingQuantity);
                $batch->decrement('quantity', $consumed);
                $remainingQuantity -= $consumed;

                $movement = StockMovement::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'batch_id' => $batch->id,
                    'quantity' => $consumed,
                    'type' => 'OUT',
                    'movement_type' => $data['movement_type'] ?? 'SALE',
                    'reference_id' => $data['reference_id'] ?? null,
                    'reference_type' => $data['reference_type'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'user_id' => auth()->id()
                ]);

                $batchesConsumed[] = [
                    'batch' => $batch,
                    'quantity' => $consumed,
                    'cost' => $batch->cost_price * $consumed
                ];

                $movements[] = $movement;
            }

            if ($remainingQuantity > 0) {
                throw new Exception("Could not fulfill entire quantity");
            }

            return [
                'batches_consumed' => $batchesConsumed,
                'movements' => $movements,
                'total_cost' => collect($batchesConsumed)->sum('cost')
            ];
        });
    }

    /**
     * Transferir stock entre armazéns
     */
    public function transferStock(Product $product, Warehouse $from, Warehouse $to, $quantity, $data = [])
    {
        // Registrar saída do armazém origem
        $outgoing = $this->registerOutgoingStock($product, $from, $quantity, [
            'movement_type' => 'TRANSFER_OUT',
            'notes' => "Transfer to {$to->name}"
        ]);

        // Registrar entrada no armazém destino
        $incoming = $this->registerIncomingStock($product, $to, $quantity, 
            $outgoing['batches_consumed'][0]['batch']->cost_price, [
                'movement_type' => 'TRANSFER_IN',
                'notes' => "Transfer from {$from->name}"
            ]
        );

        return [
            'outgoing' => $outgoing,
            'incoming' => $incoming
        ];
    }

    /**
     * Ajustar stock (inventário físico)
     */
    public function adjustStock(Product $product, Warehouse $warehouse, $newQuantity, $reason = '')
    {
        $currentQuantity = $product->batches()
            ->where('warehouse_id', $warehouse->id)
            ->sum('quantity');

        $difference = $newQuantity - $currentQuantity;

        if ($difference > 0) {
            // Ajuste positivo
            return $this->registerIncomingStock($product, $warehouse, $difference, 
                $product->average_cost, [
                    'movement_type' => 'ADJUSTMENT',
                    'notes' => "Positive adjustment: $reason"
                ]
            );
        } elseif ($difference < 0) {
            // Ajuste negativo
            return $this->registerOutgoingStock($product, $warehouse, abs($difference), [
                'movement_type' => 'ADJUSTMENT',
                'notes' => "Negative adjustment: $reason"
            ]);
        }

        return null;
    }
}
<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Branch;
use App\Models\User;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleService
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Criar nova venda
     */
    public function createSale(Branch $branch, User $customer, User $seller, $items, $data = [])
    {
        return DB::transaction(function () use ($branch, $customer, $seller, $items, $data) {
            // Validar limites de venda
            $this->validateSaleLimits($branch, $items);

            // Criar a venda
            $sale = Sale::create([
                'invoice_number' => $this->generateInvoiceNumber($branch),
                'customer_id' => $customer->id,
                'branch_id' => $branch->id,
                'user_id' => $seller->id,
                'status' => 'draft',
                'payment_method' => $data['payment_method'] ?? 'cash',
                'notes' => $data['notes'] ?? null,
                'due_date' => $data['due_date'] ?? null
            ]);

            // Processar itens
            $subtotal = 0;
            
            foreach ($items as $itemData) {
                $item = $this->addSaleItem($sale, $itemData);
                $subtotal += $item->total;
            }

            // Calcular totais
            $taxAmount = $subtotal * ($branch->default_tax_rate / 100);
            $total = $subtotal + $taxAmount;

            // Atualizar venda com totais
            $sale->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'status' => 'confirmed'
            ]);

            // Se não for a crédito, processar stock
            if ($sale->payment_method !== 'credit') {
                $this->processSaleStock($sale);
            }

            return $sale;
        });
    }

    /**
     * Adicionar item à venda
     */
    public function addSaleItem(Sale $sale, $itemData)
    {
        $product = Product::findOrFail($itemData['product_id']);
        $packaging = $product->packagings()
            ->where('code', $itemData['packaging_type'] ?? 'UN')
            ->firstOrFail();

        $quantity = $itemData['quantity'] * $packaging->conversion_factor;
        $unitPrice = $this->getProductPrice($product, $sale->branch, $packaging->code);
        
        $discountRate = $itemData['discount_rate'] ?? 0;
        $discountAmount = ($unitPrice * $quantity) * ($discountRate / 100);
        $total = ($unitPrice * $quantity) - $discountAmount;

        $item = SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'tax_rate' => $sale->branch->default_tax_rate,
            'discount_rate' => $discountRate,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'packaging_type' => $packaging->code,
            'packaging_factor' => $packaging->conversion_factor
        ]);

        return $item;
    }

    /**
     * Processar movimento de stock para venda
     */
    public function processSaleStock(Sale $sale)
    {
        foreach ($sale->items as $item) {
            if ($item->product->track_stock) {
                $warehouse = $sale->branch->main_warehouse;
                
                $this->stockService->registerOutgoingStock(
                    $item->product, 
                    $warehouse, 
                    $item->quantity,
                    [
                        'movement_type' => 'SALE',
                        'reference_id' => $sale->id,
                        'reference_type' => Sale::class
                    ]
                );
            }
        }
    }

    /**
     * Validar limites de venda
     */
    protected function validateSaleLimits(Branch $branch, $items)
    {
        $limits = $branch->saleLimits;
        if (!$limits || !$limits->is_active) return;

        // Validar número de linhas
        if (count($items) > $limits->max_lines) {
            throw new Exception("Maximum number of items exceeded");
        }

        $totalQuantity = 0;
        $totalAmount = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $packaging = $product->packagings()
                ->where('code', $item['packaging_type'] ?? 'UN')
                ->first();

            $quantity = $item['quantity'] * ($packaging->conversion_factor ?? 1);
            
            // Validar quantidade por linha
            if ($quantity > $limits->max_quantity_per_line) {
                throw new Exception("Maximum quantity per item exceeded");
            }

            $totalQuantity += $quantity;
            $unitPrice = $this->getProductPrice($product, $branch, $item['packaging_type'] ?? 'UN');
            $totalAmount += $unitPrice * $quantity;
        }

        // Validar quantidade total
        if ($totalQuantity > $limits->max_total_quantity) {
            throw new Exception("Maximum total quantity exceeded");
        }

        // Validar valor total
        if ($totalAmount > $limits->max_total_amount) {
            throw new Exception("Maximum total amount exceeded");
        }
    }

    /**
     * Obter preço do produto
     */
    protected function getProductPrice(Product $product, Branch $branch, $packagingType = 'UN')
    {
        $priceList = $branch->priceLists()->where('is_default', true)->first();
        
        if ($priceList) {
            $priceListItem = $priceList->items()
                ->where('product_id', $product->id)
                ->where('packaging_type', $packagingType)
                ->first();

            if ($priceListItem) {
                return $priceListItem->price;
            }
        }

        // Preço padrão se não encontrado na lista
        $batch = $product->batches()->orderBy('created_at', 'desc')->first();
        return $batch ? $batch->selling_price : 0;
    }

    /**
     * Gerar número de fatura
     */
    protected function generateInvoiceNumber(Branch $branch)
    {
        $count = Sale::where('branch_id', $branch->id)->count() + 1;
        return 'INV-' . $branch->code . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
}
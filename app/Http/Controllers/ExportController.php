<?php
namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Sample data
        $sheet->setCellValue('A1', 'Item')
              ->setCellValue('B1', 'Price')
              ->setCellValue('A2', 'Laptop')
              ->setCellValue('B2', 1499.99);

        // Save file
        $writer = new Xlsx($spreadsheet);
        $filename = 'export_'.date('Ymd_His').'.xlsx';
        $path = storage_path('app/'.$filename);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend();
    }
}
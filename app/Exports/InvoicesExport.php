<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoicesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            'Sr.No.',
            'Invoice No',
            'Invoice Date',
            'Invoice Type',
            'Proforma No',
            'Bill To',
            'Mobile No',
            'Grand Total',
            'Total Tax',
            'Total Amount',
            'Created At',
        ];
    }

    public function map($invoice): array
    {
        static $counter = 0;
        $counter++;
        
        return [
            $counter,
            $invoice->unique_code ?? 'N/A',
            $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : 'N/A',
            $invoice->invoice_type == 'gst' ? 'GST' : 'Without GST',
            $invoice->proforma ? $invoice->proforma->unique_code : 'N/A',
            $invoice->company_name ?? 'N/A',
            $invoice->mobile_no ?? 'N/A',
            number_format($invoice->sub_total ?? 0, 2),
            number_format($invoice->total_tax_amount ?? 0, 2),
            number_format($invoice->final_amount ?? 0, 2),
            $invoice->created_at->format('d/m/Y H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:K1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9EAD3'],
                ],
            ],
        ];
    }
}

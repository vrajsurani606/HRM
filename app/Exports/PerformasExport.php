<?php

namespace App\Exports;

use App\Models\Proforma;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PerformasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $performas;

    public function __construct($performas)
    {
        $this->performas = $performas;
    }

    public function collection()
    {
        return $this->performas;
    }

    public function headings(): array
    {
        return [
            'Sr.No.',
            'Proforma No',
            'Proforma Date',
            'Bill To',
            'Mobile No',
            'Grand Total',
            'Discount',
            'Total Tax',
            'Total Amount',
            'Type of Billing',
            'Created At',
        ];
    }

    public function map($proforma): array
    {
        static $counter = 0;
        $counter++;
        
        return [
            $counter,
            $proforma->unique_code ?? 'N/A',
            $proforma->proforma_date ? $proforma->proforma_date->format('d/m/Y') : 'N/A',
            $proforma->company_name ?? 'N/A',
            $proforma->mobile_no ?? 'N/A',
            number_format($proforma->sub_total ?? 0, 2),
            number_format($proforma->discount_amount ?? 0, 2),
            number_format($proforma->total_tax_amount ?? 0, 2),
            number_format($proforma->final_amount ?? 0, 2),
            $proforma->type_of_billing ?? 'N/A',
            $proforma->created_at->format('d/m/Y H:i:s'),
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

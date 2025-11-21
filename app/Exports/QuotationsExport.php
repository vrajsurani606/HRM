<?php

namespace App\Exports;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuotationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $quotations;

    public function __construct($quotations)
    {
        $this->quotations = $quotations;
    }

    public function collection()
    {
        return $this->quotations;
    }

    public function headings(): array
    {
        return [
            'Sr.No.',
            'Code',
            'Company Name',
            'Mobile',
            'Update',
            'Next Update',
            'Remark',
            'Is Confirm',
            'Contact Person',
            'Email',
            'Address',
            'GST No',
            'Quotation Date',
            'Tentative Complete Date',
            'Total Amount',
            'Created At',
        ];
    }

    public function map($quotation): array
    {
        static $counter = 0;
        $counter++;
        
        return [
            $counter,
            $quotation->unique_code ?? 'N/A',
            $quotation->company_name ?? 'N/A',
            $quotation->contact_number_1 ?? 'N/A',
            $quotation->updated_at ? $quotation->updated_at->format('d/m/Y') : 'N/A',
            $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : 'N/A',
            ucfirst($quotation->status ?? 'Draft'),
            $quotation->is_confirmed ? 'Yes' : 'No',
            $quotation->contact_person ?? 'N/A',
            $quotation->email ?? 'N/A',
            $quotation->address ?? 'N/A',
            $quotation->gst_no ?? 'N/A',
            $quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') : 'N/A',
            $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : 'N/A',
            $quotation->total_amount ?? 0,
            $quotation->created_at->format('d/m/Y H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Styling a specific cell by coordinate
            'A1:P1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9EAD3'],
                ],
            ],
        ];
    }
}

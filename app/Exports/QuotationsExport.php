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
    public function collection()
    {
        return Quotation::with('company')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Quotation Number',
            'Company',
            'Contact',
            'Date',
            'Status',
            'Subtotal',
            'Tax',
            'Total',
            'Created At',
        ];
    }

    public function map($quotation): array
    {
        return [
            $quotation->id,
            $quotation->unique_code,
            $quotation->company->company_name ?? $quotation->company_name ?? 'N/A',
            $quotation->company->contact_person_mobile ?? $quotation->company_phone ?? 'N/A',
            $quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') : 'N/A',
            ucfirst($quotation->status ?? 'draft'),
            $quotation->subtotal ?? 0,
            $quotation->tax_amount ?? 0,
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
            'A1:J1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9EAD3'],
                ],
            ],
        ];
    }
}

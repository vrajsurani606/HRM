<?php

namespace App\Exports;

use App\Models\Receipt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReceiptsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $receipts;

    public function __construct($receipts)
    {
        $this->receipts = $receipts;
    }

    public function collection()
    {
        return $this->receipts;
    }

    public function headings(): array
    {
        return [
            'Sr.No.',
            'Receipt No',
            'Receipt Date',
            'Company Name',
            'Invoice Type',
            'Received Amount',
            'Payment Type',
            'Trans Code',
            'Narration',
            'Created At',
        ];
    }

    public function map($receipt): array
    {
        static $counter = 0;
        $counter++;
        
        return [
            $counter,
            $receipt->unique_code ?? 'N/A',
            $receipt->receipt_date ? $receipt->receipt_date->format('d/m/Y') : 'N/A',
            $receipt->company_name ?? 'N/A',
            $receipt->invoice_type == 'gst' ? 'GST' : 'Without GST',
            number_format($receipt->received_amount ?? 0, 2),
            $receipt->payment_type ?? 'N/A',
            $receipt->trans_code ?? 'N/A',
            $receipt->narration ?? 'N/A',
            $receipt->created_at->format('d/m/Y H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:J1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9EAD3'],
                ],
            ],
        ];
    }
}

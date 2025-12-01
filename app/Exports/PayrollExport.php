<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $payrolls;

    public function __construct($payrolls)
    {
        $this->payrolls = $payrolls;
    }

    public function collection()
    {
        return $this->payrolls;
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Month',
            'Year',
            'Basic Salary',
            'HRA',
            'Medical Allowance',
            'City Allowance',
            'Tiffin Allowance',
            'Assistant Allowance',
            'Dearness Allowance',
            'Total Allowances',
            'Bonuses',
            'PF',
            'Professional Tax',
            'TDS',
            'ESIC',
            'Security Deposit',
            'Leave Deduction',
            'Leave Days',
            'Total Deductions',
            'Net Salary',
            'Payment Date',
            'Payment Method',
            'Status',
            'Notes'
        ];
    }

    public function map($payroll): array
    {
        $totalAllowances = ($payroll->hra ?? 0) + ($payroll->medical_allowance ?? 0) + 
                          ($payroll->city_allowance ?? 0) + ($payroll->tiffin_allowance ?? 0) + 
                          ($payroll->assistant_allowance ?? 0) + ($payroll->dearness_allowance ?? 0);
        $totalDeductions = ($payroll->pf ?? 0) + ($payroll->professional_tax ?? 0) + 
                          ($payroll->tds ?? 0) + ($payroll->esic ?? 0) + 
                          ($payroll->security_deposit ?? 0) + ($payroll->leave_deduction ?? 0);
        $netSalary = ($payroll->basic_salary + $totalAllowances + ($payroll->bonuses ?? 0)) - $totalDeductions;

        return [
            $payroll->employee->code ?? 'N/A',
            $payroll->employee->name ?? 'N/A',
            $payroll->month,
            $payroll->year,
            number_format($payroll->basic_salary, 2, '.', ''),
            number_format($payroll->hra ?? 0, 2, '.', ''),
            number_format($payroll->medical_allowance ?? 0, 2, '.', ''),
            number_format($payroll->city_allowance ?? 0, 2, '.', ''),
            number_format($payroll->tiffin_allowance ?? 0, 2, '.', ''),
            number_format($payroll->assistant_allowance ?? 0, 2, '.', ''),
            number_format($payroll->dearness_allowance ?? 0, 2, '.', ''),
            number_format($totalAllowances, 2, '.', ''),
            number_format($payroll->bonuses ?? 0, 2, '.', ''),
            number_format($payroll->pf ?? 0, 2, '.', ''),
            number_format($payroll->professional_tax ?? 0, 2, '.', ''),
            number_format($payroll->tds ?? 0, 2, '.', ''),
            number_format($payroll->esic ?? 0, 2, '.', ''),
            number_format($payroll->security_deposit ?? 0, 2, '.', ''),
            number_format($payroll->leave_deduction ?? 0, 2, '.', ''),
            $payroll->leave_deduction_days ?? 0,
            number_format($totalDeductions, 2, '.', ''),
            number_format($netSalary, 2, '.', ''),
            $payroll->payment_date ?? '',
            $payroll->payment_method ?? '',
            ucfirst($payroll->status),
            $payroll->notes ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 25,
            'C' => 12,
            'D' => 8,
            'E' => 15,
            'F' => 15,
            'G' => 18,
            'H' => 15,
            'I' => 15,
            'J' => 18,
            'K' => 18,
            'L' => 18,
            'M' => 12,
            'N' => 12,
            'O' => 18,
            'P' => 12,
            'Q' => 12,
            'R' => 18,
            'S' => 18,
            'T' => 12,
            'U' => 18,
            'V' => 15,
            'W' => 15,
            'X' => 18,
            'Y' => 12,
            'Z' => 30,
        ];
    }
}

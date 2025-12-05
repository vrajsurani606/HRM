<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $payroll->employee->name }}</title>
    <style>
        @page { 
            size: A4 portrait; 
            margin: 10mm 12mm;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 9pt; 
            line-height: 1.3; 
            color: #1a1a1a; 
            background: #f5f5f5; 
        }
        .container { 
            max-width: 210mm;
            margin: 20px auto; 
            padding: 20px; 
            background: #fff; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        .header { 
            border: 1px solid #d1d5db; 
            padding: 12px; 
            margin-bottom: 10px; 
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%); 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        .logo-box { 
            width: 60px; 
            height: 60px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            flex-shrink: 0; 
        }
        .logo-box img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .company-info { flex: 1; }
        .company-name { 
            font-size: 14pt; 
            font-weight: bold; 
            color: #1e40af; 
            margin-bottom: 4px; 
            letter-spacing: 0.3px; 
        }
        .company-address { 
            font-size: 8pt; 
            line-height: 1.4; 
            color: #4b5563; 
        }
        .slip-title { 
            text-align: center; 
            font-size: 11pt; 
            font-weight: bold; 
            padding: 8px; 
            border: 1px solid #d1d5db; 
            margin-bottom: 10px; 
            background: #eff6ff; 
            color: #1e40af; 
            letter-spacing: 1.5px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px; 
        }
        .info-table { border: 1px solid #d1d5db; }
        .info-table td { 
            border: 1px solid #e5e7eb; 
            padding: 6px 8px; 
            font-size: 8.5pt; 
        }
        .info-table td:nth-child(odd) { 
            font-weight: 600; 
            width: 25%; 
            background: #f9fafb; 
            color: #374151; 
        }
        .info-table td:nth-child(even) { color: #1f2937; }
        .section-header { 
            background: #dbeafe; 
            color: #1e40af; 
            font-weight: bold; 
            padding: 6px 10px; 
            font-size: 9pt; 
            text-transform: uppercase; 
            letter-spacing: 0.3px; 
            border-left: 3px solid #1e40af; 
            margin-top: 4px;
            margin-bottom: 4px;
        }
        .salary-table { border: 1px solid #d1d5db; }
        .salary-table th { 
            background: #eff6ff; 
            color: #1e40af; 
            padding: 6px 8px; 
            font-size: 9pt; 
            font-weight: bold; 
            border: 1px solid #d1d5db; 
            text-align: left; 
        }
        .salary-table td { 
            border: 1px solid #e5e7eb; 
            padding: 5px 8px; 
            font-size: 8.5pt; 
        }
        .salary-table td.amount { 
            text-align: right; 
            font-weight: 600; 
            color: #1f2937; 
        }
        .total-row { 
            background: #f3f4f6; 
            font-weight: bold; 
        }
        .net-salary-row { 
            background: #dbeafe; 
            color: #1e40af; 
            font-size: 10pt; 
            border-top: 2px solid #1e40af; 
        }
        .net-salary-row td { color: #1e40af; }
        .net-salary-row td:last-child { 
            font-weight: bold; 
            font-size: 12pt; 
        }

        .signatures { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 20px; 
            gap: 15px; 
        }
        .signature-box { text-align: center; flex: 1; }
        .signature-line { 
            border-top: 1.5px solid #6b7280; 
            margin-top: 30px; 
            margin-bottom: 6px; 
        }
        .signature-label { 
            font-size: 8.5pt; 
            font-weight: 600; 
            color: #374151; 
        }
        .print-button { 
            position: fixed; 
            top: 20px; 
            right: 20px; 
            background: #1e40af; 
            color: #fff; 
            border: none; 
            padding: 12px 24px; 
            font-weight: 600; 
            cursor: pointer; 
            border-radius: 6px; 
            box-shadow: 0 2px 8px rgba(30,64,175,0.3); 
            font-size: 11pt; 
            z-index: 1000;
        }
        .print-button:hover { background: #1e3a8a; }
        @media print { 
            @page {
                size: A4 portrait;
                margin: 12mm 15mm;
            }
            .print-button { display: none !important; } 
            body { 
                background: #fff; 
                margin: 0;
                padding: 0;
                font-size: 9pt;
                line-height: 1.3;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            } 
            .container { 
                box-shadow: none; 
                margin: 0; 
                padding: 0;
                max-width: 100%;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
            }
            .header { 
                page-break-inside: avoid;
                padding: 10px;
                margin-bottom: 8px;
                gap: 10px;
            }
            .logo-box {
                width: 55px;
                height: 55px;
            }
            .company-name {
                font-size: 13pt;
                margin-bottom: 3px;
                letter-spacing: 0.3px;
            }
            .company-address {
                font-size: 7.5pt;
                line-height: 1.3;
            }
            .slip-title {
                font-size: 10pt;
                padding: 7px;
                margin-bottom: 8px;
                letter-spacing: 1.2px;
            }
            .section-header {
                page-break-after: avoid;
                padding: 5px 9px;
                font-size: 8.5pt;
                margin-bottom: 4px;
                margin-top: 6px;
            }
            table {
                page-break-inside: auto;
                margin-bottom: 6px;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            .info-table td {
                padding: 5px 7px;
                font-size: 8pt;
                line-height: 1.3;
            }
            .salary-table th {
                padding: 5px 7px;
                font-size: 8.5pt;
            }
            .salary-table td {
                padding: 5px 7px;
                font-size: 8pt;
                line-height: 1.3;
            }
            .total-row td {
                padding: 6px 7px;
                font-size: 8.5pt;
            }
            .net-salary-row {
                font-size: 9pt;
            }
            .net-salary-row td {
                padding: 7px 7px;
            }
            .net-salary-row td:last-child {
                font-size: 11pt;
            }
            .signatures {
                page-break-inside: avoid;
                margin-top: auto;
                padding-top: 25px;
                gap: 15px;
            }
            .signature-line {
                margin-top: 35px;
                margin-bottom: 5px;
            }
            .signature-label {
                font-size: 8pt;
            }
            .signature-box > div:last-child {
                font-size: 7.5pt;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨 PRINT</button>
    <div class="container">
        <div class="header">
            <div class="logo-box">
                <img src="{{ asset('logo.png') }}" alt="Company Logo" onerror="this.style.display='none'">
            </div>
            <div class="company-info">
                <div class="company-name">CHITRI ENLARGE SOFT IT HUB PVT. LTD</div>
                <div class="company-address">
                    Raj Imperia, Police Station, 244/45, Vraj Chowk, near Sarthana, Vrajbhumi Twp Sector-1, Nana Varachha, Surat, Gujarat 395006<br>
                    📞 +91 72763 23999| 📧 hr@chitrienlarge.com | cesihpl.com
                </div>
            </div>
        </div>
        <div class="slip-title">SALARY SLIP FOR {{ strtoupper($payroll->month) }} {{ $payroll->year }}</div>
        <div class="section-header">EMPLOYEE INFORMATION</div>
        <table class="info-table">
            <tr>
                <td>Employee Name</td>
                <td><strong style="color: #1e40af;">{{ strtoupper($payroll->employee->name) }}</strong></td>
                <td>Employee Code</td>
                <td>{{ $payroll->employee->code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Designation</td>
                <td>{{ $payroll->employee->position ?? 'N/A' }}</td>
                   <td>Bank Account Number</td>
                <td>{{ $payroll->employee->bank_account_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Date of Joining</td>
                <td>{{ $payroll->employee->joining_date ? \Carbon\Carbon::parse($payroll->employee->joining_date)->format('d-M-Y') : 'N/A' }}</td>
                <td>Bank Name</td>
                <td>{{ $payroll->employee->bank_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $payroll->employee->email ?? 'N/A' }}</td>
                <td>IFSC Code</td>
                <td>{{ $payroll->employee->bank_ifsc ?? 'N/A' }}</td>
            </tr>
        </table>
        @php
            $monthNumber = date('n', strtotime($payroll->month . ' 1'));
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $payroll->year);
            
            // Get detailed leave breakdown
            $casualLeave = \App\Models\Leave::where('employee_id', $payroll->employee_id)
                ->where('leave_type', 'casual')->where('status', 'approved')
                ->whereYear('start_date', $payroll->year)->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            $medicalLeave = \App\Models\Leave::where('employee_id', $payroll->employee_id)
                ->where('leave_type', 'medical')->where('status', 'approved')
                ->whereYear('start_date', $payroll->year)->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            $personalLeave = \App\Models\Leave::where('employee_id', $payroll->employee_id)
                ->where('leave_type', 'personal')->where('status', 'approved')
                ->whereYear('start_date', $payroll->year)->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            $totalLeave = $casualLeave + $medicalLeave + $personalLeave;
            // Working days = Total days - unpaid leaves only (personal leaves)
            $workingDays = $daysInMonth - $personalLeave;
            $paidLeaveDays = $casualLeave + $medicalLeave;
            $perDaySalary = $daysInMonth > 0 ? $payroll->basic_salary / $daysInMonth : 0;
            
            // Use actual database values for allowances and deductions
            $actualHra = $payroll->hra ?? 0;
            $actualMedicalAllowance = $payroll->medical_allowance ?? 0;
            $actualCityAllowance = $payroll->city_allowance ?? 0;
            $actualTiffinAllowance = $payroll->tiffin_allowance ?? 0;
            $actualAssistantAllowance = $payroll->assistant_allowance ?? 0;
            $actualDearnessAllowance = $payroll->dearness_allowance ?? 0;
            
            $actualPf = $payroll->pf ?? 0;
            $actualProfessionalTax = $payroll->professional_tax ?? 0;
            $actualTds = $payroll->tds ?? 0;
            $actualEsic = $payroll->esic ?? 0;
            $actualSecurityDeposit = $payroll->security_deposit ?? 0;
            $actualLeaveDeduction = $payroll->leave_deduction ?? 0;
            
            // Calculate gross earnings properly by summing all allowances
            $totalAllowances = $actualHra + $actualMedicalAllowance + $actualCityAllowance + 
                              $actualTiffinAllowance + $actualAssistantAllowance + $actualDearnessAllowance;
            $grossEarnings = $payroll->basic_salary + $totalAllowances + $payroll->bonuses;
            $totalDeductionsActual = $actualPf + $actualProfessionalTax + $actualTds + $actualEsic + $actualSecurityDeposit + $actualLeaveDeduction;
            
            // Verify leave deduction calculation
            $calculatedLeaveDeduction = $personalLeave * $perDaySalary;
            
            // Calculate net salary
            $calculatedNetSalary = $grossEarnings - $totalDeductionsActual;
        @endphp
        
        <div class="section-header">ATTENDANCE & LEAVE SUMMARY</div>
        <table class="info-table">
            <tr>
                <td>Total Days in Month</td><td>{{ $daysInMonth }}</td>
                <td>Actual Working Days</td><td>{{ $workingDays }}</td>
            </tr>
            <tr>
                <td>Casual Leave (Paid)</td><td>{{ $casualLeave }}</td>
                <td>Medical Leave (Paid)</td><td>{{ $medicalLeave }}</td>
            </tr>
            <tr>
                <td>Personal Leave (Unpaid)</td><td>{{ $personalLeave }}</td>
                <td>Total Paid Leave Days</td><td>{{ $paidLeaveDays }}</td>
            </tr>
            <tr>
                <td>Per Day Salary</td><td>₹ {{ number_format($perDaySalary, 2) }}</td>
                <td>Payable Days</td><td>{{ $daysInMonth - $personalLeave }}</td>
            </tr>
        </table>
        
        <div class="section-header">SALARY BREAKDOWN</div>
        <table class="salary-table">
            <thead>
                <tr>
                    <th style="width: 40%;">EARNINGS</th>
                    <th style="width: 15%; text-align: right;">AMOUNT (₹)</th>
                    <th style="width: 30%;">DEDUCTIONS</th>
                    <th style="width: 15%; text-align: right;">AMOUNT (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td class="amount">{{ number_format($payroll->basic_salary, 2) }}</td>
                    <td>Provident Fund (PF)</td>
                    <td class="amount">{{ number_format($actualPf, 2) }}</td>
                </tr>
                <tr>
                    <td>House Rent Allowance (HRA)</td>
                    <td class="amount">{{ number_format($actualHra, 2) }}</td>
                    <td>Professional Tax (PT)</td>
                    <td class="amount">{{ number_format($actualProfessionalTax, 2) }}</td>
                </tr>
                <tr>
                    <td>Medical Allowance</td>
                    <td class="amount">{{ number_format($actualMedicalAllowance, 2) }}</td>
                    <td>Tax Deducted at Source (TDS)</td>
                    <td class="amount">{{ number_format($actualTds, 2) }}</td>
                </tr>
                <tr>
                    <td>City Compensatory Allowance</td>
                    <td class="amount">{{ number_format($actualCityAllowance, 2) }}</td>
                    <td>Employee State Insurance (ESIC)</td>
                    <td class="amount">{{ number_format($actualEsic, 2) }}</td>
                </tr>
                <tr>
                    <td>Tiffin Allowance</td>
                    <td class="amount">{{ number_format($actualTiffinAllowance, 2) }}</td>
                    <td>Security Deposit</td>
                    <td class="amount">{{ number_format($actualSecurityDeposit, 2) }}</td>
                </tr>
                <tr>
                    <td>Assistant Allowance</td>
                    <td class="amount">{{ number_format($actualAssistantAllowance, 2) }}</td>
                    <td>Leave Deduction ({{ $personalLeave }} days)</td>
                    <td class="amount">{{ number_format($calculatedLeaveDeduction, 2) }}</td>
                </tr>
                <tr>
                    <td>Dearness Allowance</td>
                    <td class="amount">{{ number_format($actualDearnessAllowance, 2) }}</td>
                    <td>-</td>
                    <td class="amount">-</td>
                </tr>
                <tr>
                    <td>Special Bonus</td>
                    <td class="amount">{{ number_format($payroll->bonuses, 2) }}</td>
                    <td>-</td>
                    <td class="amount">-</td>
                </tr>
                <tr class="total-row">
                    <td><strong>GROSS EARNINGS</strong></td>
                    <td class="amount">{{ number_format($grossEarnings, 2) }}</td>
                    <td><strong>TOTAL DEDUCTIONS</strong></td>
                    <td class="amount">{{ number_format($totalDeductionsActual, 2) }}</td>
                </tr>
                <tr class="net-salary-row">
                    <td colspan="3"><strong>NET SALARY (Take Home Salary)</strong></td>
                    <td class="amount">{{ number_format($calculatedNetSalary, 2) }}</td>
                </tr>
            </tbody>
        </table>
        
        <!-- Payment Details -->
        <div class="section-header">PAYMENT INFORMATION</div>
        <table class="info-table">
            <tr>
                <td>Payment Date</td>
                <td>{{ $payroll->payment_date ? $payroll->payment_date->format('d-M-Y') : 'Not Paid Yet' }}</td>
                <td>Payment Method</td>
                <td>{{ strtoupper($payroll->payment_method ?? 'BANK TRANSFER') }}</td>
            </tr>
            <tr>
                <td>Payment Status</td>
                <td>{{ strtoupper($payroll->status) }}</td>
                <td>Slip Generated On</td>
                <td>{{ now()->format('d-M-Y h:i A') }}</td>
            </tr>
        </table>
        
        <!-- Important Notes Section -->
        {{-- <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin: 20px 0; font-size: 10pt;">
            <div style="font-weight: bold; color: #1e40af; margin-bottom: 8px;">📋 SALARY CALCULATION NOTES:</div>
            <ul style="margin: 0; padding-left: 20px; line-height: 1.6; color: #4b5563;">
                <li><strong>Basic Salary:</strong> ₹{{ number_format($payroll->basic_salary, 2) }} for {{ $daysInMonth }} days</li>
                <li><strong>Per Day Salary:</strong> ₹{{ number_format($perDaySalary, 2) }}</li>
                <li><strong>Total Allowances:</strong> ₹{{ number_format($totalAllowances, 2) }}</li>
                <li><strong>Gross Earnings:</strong> Basic (₹{{ number_format($payroll->basic_salary, 2) }}) + Allowances (₹{{ number_format($totalAllowances, 2) }}) + Bonus (₹{{ number_format($payroll->bonuses, 2) }}) = ₹{{ number_format($grossEarnings, 2) }}</li>
                <li><strong>Leave Deduction:</strong> {{ $personalLeave }} unpaid days × ₹{{ number_format($perDaySalary, 2) }} = ₹{{ number_format($calculatedLeaveDeduction, 2) }}</li>
                <li><strong>Total Deductions:</strong> ₹{{ number_format($totalDeductionsActual, 2) }}</li>
                <li><strong>Net Salary:</strong> Gross (₹{{ number_format($grossEarnings, 2) }}) - Deductions (₹{{ number_format($totalDeductionsActual, 2) }}) = ₹{{ number_format($calculatedNetSalary, 2) }}</li>
                <li><strong>Leave Policy:</strong> Casual & Medical leaves are paid, Personal leaves are unpaid</li>
            </ul>
            @if(abs($calculatedLeaveDeduction - $actualLeaveDeduction) > 0.01)
            <div style="margin-top: 8px; padding: 8px; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 4px;">
                <strong style="color: #92400e;">Note:</strong> Calculated leave deduction (₹{{ number_format($calculatedLeaveDeduction, 2) }}) differs from stored value (₹{{ number_format($actualLeaveDeduction, 2) }})
            </div>
            @endif
            @if($payroll->notes)
            <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                <strong style="color: #dc2626;">Additional Note:</strong> {{ $payroll->notes }}
            </div>
            @endif
        </div> --}}
        
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Employee Signature</div>
                <div style="font-size: 9pt; color: #6b7280;">{{ $payroll->employee->name }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Authorized Signatory</div>
                <div style="font-size: 9pt; color: #6b7280;">Finance Department</div>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
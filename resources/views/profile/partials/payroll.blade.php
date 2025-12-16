<div>
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Payroll History') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('View your salary payment history and details.') }}
    </p>
  </div>

  @if(isset($payslips) && $payslips->count() > 0)
  <!-- Payroll Table Section -->
  <div style="background:white;padding:0;margin:0">
    <!-- Payroll Data Table -->
    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
        <thead>
          <tr style="background:#f8f9fa;border-bottom:1px solid #e5e7eb">
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Sr.</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Unique No</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Salary Month</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Payment Date</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Payment Method</th>
            <th style="padding:16px 12px;text-align:right;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Net Salary</th>
            <th style="padding:16px 12px;text-align:center;font-weight:600;color:#374151;font-size:14px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payslips as $index => $payslip)
          <tr style="border-bottom:1px solid #e5e7eb;{{ $loop->even ? 'background:#f9fafb;' : '' }}">
            <td style="padding:14px 12px;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">{{ $index + 1 }}</td>
            <td style="padding:14px 12px;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">{{ $payslip->unique_code ?? '-' }}</td>
            <td style="padding:14px 12px;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">
              {{ \Carbon\Carbon::create()->month($payslip->month)->format('F') }} {{ $payslip->year }}
            </td>
            <td style="padding:14px 12px;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">
              {{ $payslip->payment_date ? $payslip->payment_date->format('d/m/Y') : '-' }}
            </td>
            <td style="padding:14px 12px;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">
              {{ ucfirst($payslip->payment_method ?? '-') }}
            </td>
            <td style="padding:14px 12px;color:#374151;font-size:14px;text-align:right;font-weight:600;border-right:1px solid #e5e7eb">
              ₹{{ number_format($payslip->net_salary ?? 0, 2) }}
            </td>
            <td style="padding:14px 12px;text-align:center">
              <a href="{{ route('payroll.show', $payslip->id) }}" 
                 style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;background:#3b82f6;color:white;border-radius:6px;text-decoration:none;font-size:13px;font-weight:500;transition:background 0.2s"
                 onmouseover="this.style.background='#2563eb'" 
                 onmouseout="this.style.background='#3b82f6'">
                <i class="fa fa-eye"></i> View
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @else
  <!-- Empty State -->
  <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 80px 20px; background: #fafafa; border-radius: 12px; min-height: 350px;">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 72px; height: 72px; color: #d1d5db; margin-bottom: 20px;">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <div style="font-size: 20px; font-weight: 600; color: #374151; margin-bottom: 12px;">No Payroll Records</div>
    <div style="font-size: 15px; color: #6b7280; max-width: 400px; line-height: 1.6;">You don't have any paid salary records yet. Your salary payments will appear here once processed and paid by HR.</div>
  </div>
  @endif
</div>

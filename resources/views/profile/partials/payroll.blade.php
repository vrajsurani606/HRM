<div>
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Payroll History') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('View your salary payment history and details.') }}
    </p>
  </div>

  @php
    // Check if employee has payroll records
    $hasPayrollRecords = false; // This should be replaced with actual data check from controller
  @endphp

  @if($hasPayrollRecords)
  <!-- Payroll Table Section -->
  <div style="background:white;padding:0;margin:0">
    <!-- Payroll Data Table -->
    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
        <thead>
          <tr style="background:#f8f9fa;border-bottom:1px solid #e5e7eb">
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Action</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Serial No</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Unique No</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Salary Month</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Format Type</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px;border-right:1px solid #e5e7eb">Payment Date</th>
            <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:14px">Payment Amount</th>
          </tr>
        </thead>
        <tbody>
          <!-- Payroll records will be displayed here -->
        </tbody>
      </table>
    </div>
    
    <!-- Pagination Section -->
    <div style="display:flex;align-items:center;justify-content:space-between;padding:20px 0;border-top:1px solid #e5e7eb;margin-top:20px">
      <!-- Left side - Entries info -->
      <div style="display:flex;align-items:center;gap:8px;color:#6b7280;font-size:14px">
        <span>Entries</span>
        <select style="padding:4px 8px;border:1px solid #d1d5db;border-radius:4px;background:white;color:#374151;font-size:14px">
          <option>25</option>
          <option>50</option>
          <option>100</option>
        </select>
      </div>
      
      <!-- Right side - Pagination -->
      <div style="display:flex;align-items:center;gap:8px">
        <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
          </svg>
        </button>
        
        <button style="padding:8px 12px;border:1px solid #ef4444;background:#ef4444;color:white;border-radius:4px;font-weight:600;font-size:14px">01</button>
        
        <button style="padding:8px 12px;border:1px solid #d1d5db;background:white;color:#6b7280;border-radius:4px;cursor:pointer;font-size:14px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
  @else
  <!-- Empty State -->
  <x-empty-state 
    icon="fa-money"
    title="No Payroll Records"
    message="You don't have any payroll records yet. Your salary payments will appear here once processed by HR."
  />
  @endif
</div>
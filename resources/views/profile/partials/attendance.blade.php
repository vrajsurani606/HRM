<div>
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Attendance Management') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('View your attendance records and statistics.') }}
    </p>
  </div>

  <div class="hrp-grid" style="margin-top: 32px;">
    <div class="hrp-col-3">
      <div class="hrp-card" style="text-align: center; background: #f9fafb; border: 1px solid #e5e7eb;">
        <div class="hrp-card-body">
          <h3 style="font-size: 14px; color: #6b7280; margin-bottom: 12px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Total Days</h3>
          <p style="font-size: 32px; font-weight: 800; color: #111; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0</p>
        </div>
      </div>
    </div>
    <div class="hrp-col-3">
      <div class="hrp-card" style="text-align: center; background: #fef3c7; border-color: #fbbf24;">
        <div class="hrp-card-body">
          <h3 style="font-size: 14px; color: #92400e; margin-bottom: 12px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Present</h3>
          <p style="font-size: 32px; font-weight: 800; color: #92400e; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0</p>
        </div>
      </div>
    </div>
    <div class="hrp-col-3">
      <div class="hrp-card" style="text-align: center; background: #fee2e2; border-color: #f87171;">
        <div class="hrp-card-body">
          <h3 style="font-size: 14px; color: #991b1b; margin-bottom: 12px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Absent</h3>
          <p style="font-size: 32px; font-weight: 800; color: #991b1b; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0</p>
        </div>
      </div>
    </div>
    <div class="hrp-col-3">
      <div class="hrp-card" style="text-align: center; background: #dbeafe; border-color: #60a5fa;">
        <div class="hrp-card-body">
          <h3 style="font-size: 14px; color: #1e40af; margin-bottom: 12px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Leave</h3>
          <p style="font-size: 32px; font-weight: 800; color: #1e40af; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0</p>
        </div>
      </div>
    </div>
  </div>

  <div class="hrp-card" style="margin-top: 32px; background: #f9fafb; border: 1px solid #e5e7eb;">
    <div class="hrp-card-body">
      <h3 style="font-size: 16px; font-weight: 700; color: #111; margin: 0 0 16px 0; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
        <i class="fa fa-calendar"></i> Filter Attendance
      </h3>
      <form class="hrp-form">
        <div class="hrp-grid" style="margin-top: 20px;">
          <div class="hrp-col-4">
            <label class="hrp-label Mobile-No" for="attendance_month">Select Month</label>
            <input type="month" id="attendance_month" name="attendance_month" class="Rectangle-29" 
                   value="{{ date('Y-m') }}" />
          </div>
          <div class="hrp-col-4">
            <label class="hrp-label Mobile-No" for="attendance_year">Select Year</label>
            <input type="number" id="attendance_year" name="attendance_year" class="Rectangle-29" 
                   value="{{ date('Y') }}" min="2020" max="{{ date('Y') }}" 
                   placeholder="{{ __('Enter year') }}" />
          </div>
          <div class="hrp-col-4">
            <label class="hrp-label Mobile-No">&nbsp;</label>
            <button type="button" class="hrp-btn hrp-btn-primary" 
                    style="width: 100%; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-weight: 800; margin-top: 8px;">
              <i class="fa fa-search"></i> Filter
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div style="margin-top: 32px;">
    <h3 style="font-size: 18px; font-weight: 700; color: #111; margin-bottom: 20px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      <i class="fa fa-list"></i> Attendance Records
    </h3>
    <div class="hrp-table-wrap">
      <table class="hrp-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Working Hours</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" style="text-align: center; padding: 40px; color: #9ca3af; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              <i class="fa fa-inbox" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
              No attendance records found
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="hrp-card" style="margin-top: 32px; background: #f9fafb; border: 1px solid #e5e7eb;">
    <div class="hrp-card-body">
      <h3 style="font-size: 16px; font-weight: 700; color: #111; margin: 0 0 16px 0; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
        <i class="fa fa-calendar-times-o"></i> Leave Balance
      </h3>
      <div class="hrp-grid" style="margin-top: 20px;">
        <div class="hrp-col-4">
          <div style="display: flex; justify-content: space-between; padding: 12px 0;">
            <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Casual Leave</span>
            <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0 / 12</span>
          </div>
        </div>
        <div class="hrp-col-4">
          <div style="display: flex; justify-content: space-between; padding: 12px 0;">
            <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Sick Leave</span>
            <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0 / 10</span>
          </div>
        </div>
        <div class="hrp-col-4">
          <div style="display: flex; justify-content: space-between; padding: 12px 0;">
            <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Earned Leave</span>
            <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">0 / 15</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

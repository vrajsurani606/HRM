<div>
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Attendance Management') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('View your attendance records and statistics.') }}
    </p>
  </div>

    <!-- KPI Cards -->
    <div class="hrp-grid" style="margin: 20px 0; gap: 15px;">
      <!-- Present Days -->
      <div class="hrp-col-3">
        <div style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center;">
            <div style="margin-right: 15px; font-size: 24px; color: #3b82f6;">
              <i class="fa fa-calendar-check"></i>
            </div>
            <div>
              <div style="font-size: 24px; font-weight: 700; color: #111;">014</div>
              <div style="font-size: 13px; color: #6b7280; margin-top: 2px;">Total Present Day</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Late Arrivals -->
      <div class="hrp-col-3">
        <div style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center;">
            <div style="margin-right: 15px; font-size: 24px; color: #f59e0b;">
              <i class="fa fa-clock"></i>
            </div>
            <div>
              <div style="font-size: 24px; font-weight: 700; color: #111;">003</div>
              <div style="font-size: 13px; color: #6b7280; margin-top: 2px;">Late Arrivals</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Early Departures -->
      <div class="hrp-col-3">
        <div style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center;">
            <div style="margin-right: 15px; font-size: 24px; color: #ef4444;">
              <i class="fa fa-sign-out"></i>
            </div>
            <div>
              <div style="font-size: 24px; font-weight: 700; color: #111;">002</div>
              <div style="font-size: 13px; color: #6b7280; margin-top: 2px;">Early Departures</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Overtime -->
      <div class="hrp-col-3">
        <div style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center;">
            <div style="margin-right: 15px; font-size: 24px; color: #10b981;">
              <i class="fa fa-hourglass"></i>
            </div>
            <div>
              <div style="font-size: 24px; font-weight: 700; color: #111;">08:30</div>
              <div style="font-size: 13px; color: #6b7280; margin-top: 2px;">Overtime Hours</div>
            </div>
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

  <!-- Attendance Records Table -->
  <div class="hrp-card" style="margin-top: 32px; padding: 20px;">
    <h3 style="font-size: 18px; font-weight: 700; color: #111; margin: 0 0 20px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      <i class="fa fa-list"></i> Attendance Records
    </h3>
    
    <div class="table-responsive">
      <table id="attendanceTable" class="table table-striped table-hover" style="width:100%">
        <thead>
          <tr>
            <th>Day</th>
            <th>Date</th>
            <th>Check In/Out</th>
            <th>Overtime</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample Data Rows -->
          <tr>
            <td>Monday</td>
            <td>2025-11-01</td>
            <td>
              <div class="time-container">
                <span class="time-badge in-time">09:15</span>
                <div class="time-line">
                  <div class="time-marker start">9:30</div>
                  <div class="time-line-track">
                    <div class="time-line-progress" style="left: 0%; width: 100%;"></div>
                  </div>
                  <div class="time-marker end">18:30</div>
                </div>
                <span class="time-badge out-time">18:45</span>
              </div>
            </td>
            <td>00:15</td>
            <td><span class="status-badge status-present">Present</span></td>
          </tr>
          <tr>
            <td>Tuesday</td>
            <td>2025-11-02</td>
            <td>
              <div class="time-container">
                <span class="time-badge late-in">10:15</span>
                <div class="time-line">
                  <div class="time-marker start">9:30</div>
                  <div class="time-line-track">
                    <div class="time-line-progress" style="left: 0%; width: 100%;"></div>
                  </div>
                  <div class="time-marker end">18:30</div>
                </div>
                <span class="time-badge early-out">17:45</span>
              </div>
            </td>
            <td>00:00</td>
            <td><span class="status-badge status-late">Late In</span></td>
          </tr>
          <tr>
            <td>Wednesday</td>
            <td>2025-11-03</td>
            <td>
              <div class="time-container">
                <span class="time-badge in-time">09:25</span>
                <div class="time-line">
                  <div class="time-marker start">9:30</div>
                  <div class="time-line-track">
                    <div class="time-line-progress" style="left: 0%; width: 100%;"></div>
                  </div>
                  <div class="time-marker end">18:30</div>
                </div>
                <span class="time-badge out-time">18:50</span>
              </div>
            </td>
            <td>00:20</td>
            <td><span class="status-badge status-present">Present</span></td>
          </tr>
          <tr>
            <td>Thursday</td>
            <td>2025-11-04</td>
            <td>
              <div class="time-container">
                <span class="time-badge absent">-</span>
                <div class="time-line">
                  <div class="time-marker start">9:30</div>
                  <div class="time-line-track">
                    <div class="time-line-progress" style="left: 0%; width: 0%;"></div>
                  </div>
                  <div class="time-marker end">18:30</div>
                </div>
                <span class="time-badge absent">-</span>
              </div>
            </td>
            <td>00:00</td>
            <td><span class="status-badge status-absent">Absent</span></td>
          </tr>
          <tr>
            <td>Friday</td>
            <td>2025-11-05</td>
            <td>
              <div class="time-container">
                <span class="time-badge in-time">09:00</span>
                <div class="time-line">
                  <div class="time-marker start">9:30</div>
                  <div class="time-line-track">
                    <div class="time-line-progress" style="left: 0%; width: 50%;"></div>
                  </div>
                  <div class="time-marker end">18:30</div>
                </div>
                <span class="time-badge half-day">14:00</span>
              </div>
            </td>
            <td>00:00</td>
            <td><span class="status-badge status-halfday">Half Day</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
  <!-- Add this before the closing </div> tag -->
  <style>
    /* Time Line Styles */
    .time-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .time-badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: 600;
      font-size: 12px;
      min-width: 50px;
      text-align: center;
    }
    
    .in-time { background-color: #d1fae5; color: #065f46; }
    .out-time { background-color: #d1fae5; color: #065f46; }
    .late-in { background-color: #fef3c7; color: #92400e; }
    .early-out { background-color: #fee2e2; color: #991b1b; }
    .absent { color: #9ca3af; }
    .half-day { background-color: #fef3c7; color: #92400e; }
    
    .time-line {
      flex: 1;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .time-line-track {
      flex: 1;
      height: 6px;
      background-color: #e5e7eb;
      border-radius: 3px;
      position: relative;
      overflow: hidden;
    }
    
    .time-line-progress {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      background-color: #10b981;
      border-radius: 3px;
    }
    
    .time-marker {
      font-size: 10px;
      color: #6b7280;
      white-space: nowrap;
    }
    
    /* Status Badges */
    .status-badge {
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
      text-transform: capitalize;
    }
    
    .status-present { background-color: #d1fae5; color: #065f46; }
    .status-late { background-color: #fef3c7; color: #92400e; }
    .status-early { background-color: #fee2e2; color: #991b1b; }
    .status-absent { background-color: #f3f4f6; color: #6b7280; }
    .status-halfday { background-color: #dbeafe; color: #1e40af; }
    
    /* Table Styles */
    #attendanceTable {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 8px;
    }
    
    #attendanceTable thead th {
      background-color: #f9fafb;
      padding: 12px 15px;
      text-align: left;
      font-weight: 600;
      color: #4b5563;
      border: none;
    }
    
    #attendanceTable tbody tr {
      background-color: white;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
      border-radius: 8px;
    }
    
    #attendanceTable tbody td {
      padding: 15px;
      vertical-align: middle;
    }
    
    #attendanceTable tbody tr:hover {
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    
    /* Responsive Table */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    
    @media (max-width: 768px) {
      .hrp-col-3 {
        width: 100%;
        margin-bottom: 15px;
      }
      
      .time-container {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .time-line {
        width: 100%;
        margin: 5px 0;
      }
    }
  </style>
  
  @push('scripts')
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#attendanceTable').DataTable({
        responsive: true,
        order: [[1, 'desc']], // Sort by date descending
        pageLength: 10,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records...",
        },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
      });
      
      // Function to calculate and update time progress
      function updateTimeProgress() {
        $('.time-container').each(function() {
          const inTime = $(this).find('.in-time').text();
          const outTime = $(this).find('.out-time').text();
          
          if (inTime === '-' || outTime === '-') {
            return; // Skip if no time data
          }
          
          // Convert times to minutes since midnight for calculation
          const startTime = 9.5 * 60; // 9:30 AM in minutes
          const endTime = 18.5 * 60;  // 6:30 PM in minutes
          
          // Parse check-in time
          const [inHour, inMinute] = inTime.split(':').map(Number);
          const checkIn = inHour * 60 + inMinute;
          
          // Parse check-out time
          const [outHour, outMinute] = outTime.split(':').map(Number);
          const checkOut = outHour * 60 + outMinute;
          
          // Calculate progress
          const totalDuration = endTime - startTime;
          const workedDuration = checkOut - checkIn;
          const progressPercent = (workedDuration / totalDuration) * 100;
          
          // Update progress bar
          $(this).find('.time-line-progress').css('width', Math.min(100, Math.max(0, progressPercent)) + '%');
        });
      }
      
      // Initial update
      updateTimeProgress();
    });
  </script>
  @endpush

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

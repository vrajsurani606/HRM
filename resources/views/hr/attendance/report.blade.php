@extends('layouts.macos')
@section('page_title', 'Attendance Reports')

@section('content')
<div class="hrp-content">
  <!-- Filter Row -->
  <form method="GET" action="{{ route('attendance.report') }}" class="jv-filter" id="filterForm" data-no-loader="true">
    <input type="text" name="start_date" class="filter-pill date-picker" placeholder="From : dd/mm/yy" value="{{ request('start_date') }}" autocomplete="off" style="min-width: 130px;">
    <input type="text" name="end_date" class="filter-pill date-picker" placeholder="To : dd/mm/yy" value="{{ request('end_date') }}" autocomplete="off" style="min-width: 130px;">
    
    <select name="employee_id" class="filter-pill" style="min-width: 200px;">
      <option value="">All Employees</option>
      @foreach($employees as $emp)
        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
          {{ $emp->name }}
        </option>
      @endforeach
    </select>

    <select name="status" class="filter-pill">
      <option value="">All Status</option>
      <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
      <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
      <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
      <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
    </select>

    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>
    
    <a href="{{ route('attendance.report') }}" class="filter-search" aria-label="Reset">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>
    
    <div class="filter-right">
      @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.create attendance'))
        <a href="{{ route('attendance.create') }}" class="pill-btn pill-primary">+ Create Attendance</a>
      @endif
      @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view attendance'))
        <a href="{{ route('attendance.report.export', request()->all()) }}" class="pill-btn pill-success">Export to Excel</a>
      @endif
    </div>
  </form>

  <!-- Data Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <style>
      .JV-datatble table td:first-child {
        text-align: center !important;
      }
      .JV-datatble table td:first-child > div {
        display: inline-flex !important;
        gap: 12px;
        align-items: center;
      }
    </style>
    <table>
      <thead>
        <tr>
          <th style="width: 100px; text-align: center;">Action</th>
          <th style="width: 120px;">Date</th>
          <th style="width: 100px;">EMP Code</th>
          <th style="width: 180px;">EMPLOYEE</th>
          <th style="width: 60px; text-align: center;">Entry</th>
          <th style="width: 280px;">Check IN & OUT</th>
          <th style="width: 80px; text-align: center;">Duration</th>
          <th style="width: 80px; text-align: center;">Total</th>
          <th style="width: 100px; text-align: center;">Status</th>
        </tr>
      </thead>
      <tbody>
        @php
          // Group attendances by employee and date
          $grouped = $attendances->groupBy(function($item) {
            return $item->employee_id . '_' . $item->date->format('Y-m-d');
          });
        @endphp
        
        @forelse($grouped as $key => $dayEntries)
          @php
            $firstEntry = $dayEntries->first();
            $dayTotalSeconds = 0;
            $dayStatus = 'absent';
            $entrySecondsArr = [];
            
            foreach($dayEntries as $idx => $entry) {
              $secs = 0;
              if ($entry->check_in && $entry->check_out) {
                $inT = $entry->check_in instanceof \Carbon\Carbon ? $entry->check_in : \Carbon\Carbon::parse($entry->check_in);
                $outT = $entry->check_out instanceof \Carbon\Carbon ? $entry->check_out : \Carbon\Carbon::parse($entry->check_out);
                // Use timestamp difference for accurate calculation
                $secs = abs($outT->timestamp - $inT->timestamp);
              }
              $entrySecondsArr[$idx] = $secs;
              $dayTotalSeconds += $secs;
              if($entry->status) $dayStatus = $entry->status;
            }
            
            // Format total time as HH:MM:SS
            $totalH = floor($dayTotalSeconds / 3600);
            $totalM = floor(($dayTotalSeconds % 3600) / 60);
            $totalS = $dayTotalSeconds % 60;
            $dayTotalFormatted = sprintf('%02d:%02d:%02d', $totalH, $totalM, $totalS);
            
            $statusColors = [
              'present' => ['bg' => '#dcfce7', 'text' => '#166534'],
              'absent' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
              'half_day' => ['bg' => '#fef3c7', 'text' => '#92400e'],
              'late' => ['bg' => '#ffedd5', 'text' => '#9a3412'],
              'leave' => ['bg' => '#e0e7ff', 'text' => '#3730a3'],
              'early_leave' => ['bg' => '#fef3c7', 'text' => '#92400e'],
            ];
            $statusStyle = $statusColors[$dayStatus] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
          @endphp
          
          @foreach($dayEntries as $index => $attendance)
          <tr>
            <td style="vertical-align: middle; padding: 10px; text-align: center;">
              <div style="display: inline-flex; gap: 8px; align-items: center;">
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.edit attendance'))
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" style="cursor: pointer; width: 16px; height: 16px;" onclick="editAttendance({{ $attendance->id }})">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.delete attendance'))
                  <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" style="cursor: pointer; width: 16px; height: 16px;" onclick="deleteAttendance({{ $attendance->id }})">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view attendance'))
                  <img src="{{ asset('action_icon/print.svg') }}" alt="Print" style="cursor: pointer; width: 16px; height: 16px;" onclick="printAttendance({{ $attendance->id }})">
                @endif
              </div>
            </td>
            <td style="vertical-align: middle; font-weight: 600;">
              {{ $attendance->date->format('d M Y') }}
            </td>
            <td style="vertical-align: middle; font-size: 12px;">
              {{ $attendance->employee->code ?? 'EMP/' . str_pad($attendance->employee->id ?? '000', 4, '0', STR_PAD_LEFT) }}
            </td>
            <td style="vertical-align: middle;">{{ $attendance->employee->name ?? 'N/A' }}</td>
            <td style="vertical-align: middle; text-align: center;">
              <span style="display:inline-block;background:#e5e7eb;color:#374151;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600">
                #{{ $index + 1 }}
              </span>
            </td>
            @php
              $checkIn = $attendance->check_in ? ($attendance->check_in instanceof \Carbon\Carbon ? $attendance->check_in : \Carbon\Carbon::parse($attendance->check_in)) : null;
              $checkOut = $attendance->check_out ? ($attendance->check_out instanceof \Carbon\Carbon ? $attendance->check_out : \Carbon\Carbon::parse($attendance->check_out)) : null;
            @endphp
            <td style="vertical-align: middle; padding: 10px;" 
                data-attendance-id="{{ $attendance->id }}"
                data-check-in="{{ $checkIn ? $checkIn->format('H:i') : '' }}"
                data-check-out="{{ $checkOut ? $checkOut->format('H:i') : '' }}"
                class="time-cell">
              
              <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                @if($checkIn)
                  <span style="color:#059669; font-weight:600; font-size:13px;" class="check-in-time">{{ $checkIn->format('h:i A') }}</span>
                @else
                  <span style="color:#9ca3af;">--</span>
                @endif
                
                <span style="color:#d1d5db; font-size:12px;">→</span>
                
                @if($checkOut)
                  <span style="color:#dc2626; font-weight:600; font-size:13px;" class="check-out-time">{{ $checkOut->format('h:i A') }}</span>
                @else
                  <span style="color:#9ca3af;">--</span>
                @endif
              </div>
            </td>
            <td style="vertical-align: middle; text-align: center;">
              @if($checkIn && $checkOut)
                @php
                  $entrySecs = $entrySecondsArr[$index] ?? 0;
                  $entryH = floor($entrySecs / 3600);
                  $entryM = floor(($entrySecs % 3600) / 60);
                  $entryS = $entrySecs % 60;
                  $entryFormatted = sprintf('%02d:%02d:%02d', $entryH, $entryM, $entryS);
                @endphp
                <span style="font-weight:600; color:#374151; font-size:13px;">
                  {{ $entryFormatted }}
                </span>
              @else
                <span style="color:#9ca3af;">-</span>
              @endif
            </td>
            <td style="vertical-align: middle; text-align: center;">
              <span style="display:inline-block;background:#dbeafe;color:#1e40af;padding:3px 10px;border-radius:6px;font-weight:700;font-size:12px">
                {{ $dayTotalFormatted }}
              </span>
            </td>
            <td style="vertical-align: middle; text-align: center;">
              @php
                // Check for Late Entry (after 9:30 AM)
                $isLate = false;
                $isEarlyExit = false;
                $lateThreshold = '09:30';
                $earlyExitThreshold = '18:00';
                
                // Check Late/Early for any status where employee was present (present, late, half_day, early_leave)
                $workingStatuses = ['present', 'late', 'half_day', 'early_leave'];
                $wasAtWork = in_array($dayStatus, $workingStatuses);
                
                if ($checkIn && $wasAtWork) {
                    $checkInTime = $checkIn->format('H:i');
                    $isLate = strcmp($checkInTime, $lateThreshold) > 0;
                }
                
                // Check for Early Exit (before 6:00 PM)
                if ($checkOut && $wasAtWork) {
                    $checkOutTime = $checkOut->format('H:i');
                    $isEarlyExit = strcmp($checkOutTime, $earlyExitThreshold) < 0;
                }
              @endphp
              
              <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                {{-- Main Status Badge --}}
                <span style="display:inline-block;background:{{ $statusStyle['bg'] }};color:{{ $statusStyle['text'] }};padding:3px 10px;border-radius:6px;font-weight:600;font-size:11px;text-transform:capitalize">
                  {{ str_replace('_', ' ', $dayStatus) }}
                </span>
                
                {{-- Late/Early Indicators --}}
                @if($isLate || $isEarlyExit)
                <div style="display: flex; gap: 4px; flex-wrap: wrap; justify-content: center;">
                  @if($isLate)
                    <span style="display:inline-block;background:#fef3c7;color:#b45309;padding:2px 6px;border-radius:4px;font-weight:600;font-size:9px;text-transform:uppercase">
                      <i class="fas fa-clock" style="font-size:8px;margin-right:2px;"></i>Late
                    </span>
                  @endif
                  @if($isEarlyExit)
                    <span style="display:inline-block;background:#fee2e2;color:#dc2626;padding:2px 6px;border-radius:4px;font-weight:600;font-size:9px;text-transform:uppercase">
                      <i class="fas fa-sign-out-alt" style="font-size:8px;margin-right:2px;"></i>Early
                    </span>
                  @endif
                </div>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        @empty
          <x-empty-state 
              colspan="9" 
              title="No attendance records found" 
              message="Try adjusting your filters or create a new attendance record"
          />
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($attendances->hasPages())
  <div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $attendances->links() }}
  </div>
  @endif
</div>

<div id="timeEditModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center;">
  <div style="background: #1f2937; border-radius: 8px; padding: 20px; max-width: 320px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.5); border: 1px solid #374151;">
    <h3 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 600; color: #f3f4f6;">Edit Time</h3>
    
    <form id="timeEditForm" onsubmit="submitTimeEdit(event)">
      <input type="hidden" name="attendance_id" id="edit_attendance_id">
      
      <div style="margin-bottom: 12px;">
        <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px; color: #d1d5db;">Check In</label>
        <input type="time" name="check_in" id="edit_check_in" required style="width: 100%; padding: 8px; border: 1px solid #4b5563; border-radius: 6px; font-size: 13px; background: #374151; color: #f3f4f6;">
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 4px; font-weight: 500; font-size: 13px; color: #d1d5db;">Check Out</label>
        <input type="time" name="check_out" id="edit_check_out" style="width: 100%; padding: 8px; border: 1px solid #4b5563; border-radius: 6px; font-size: 13px; background: #374151; color: #f3f4f6;">
      </div>

      <div style="display: flex; gap: 8px; justify-content: flex-end;">
        <button type="button" onclick="closeTimeEditModal()" style="padding: 6px 14px; border: 1px solid #4b5563; background: #374151; color: #d1d5db; border-radius: 5px; cursor: pointer; font-weight: 500; font-size: 13px;">Cancel</button>
        <button type="submit" style="padding: 6px 14px; border: none; background: #3b82f6; color: white; border-radius: 5px; cursor: pointer; font-weight: 500; font-size: 13px;">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- Quick Edit Time Modal -->
<div id="quickEditTimeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 12px; padding: 25px; max-width: 350px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h3 style="margin: 0 0 15px 0; font-size: 18px; font-weight: 700; color: #1f2937;">Quick Edit Time</h3>
    
    <form id="quickEditTimeForm" onsubmit="submitQuickEditTime(event)">
      <input type="hidden" name="attendance_id" id="quick_attendance_id">
      <input type="hidden" name="field_type" id="quick_field_type">
      
      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px; color: #374151;" id="quick_time_label">Time</label>
        <input type="time" name="time_value" id="quick_time_value" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
        <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 4px;">Enter the corrected time</small>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeQuickEditTimeModal()" style="padding: 8px 16px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px;">Cancel</button>
        <button type="submit" style="padding: 8px 16px; border: none; background: #3b82f6; color: white; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px;">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Attendance Modal -->
<div id="editAttendanceModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto;">
    <h3 style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Edit Attendance Record</h3>
    
    <form id="editAttendanceForm" onsubmit="submitEditAttendance(event)">
      <input type="hidden" name="attendance_id" id="edit_attendance_id">
      
      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Employee</label>
        <select name="employee_id" id="edit_employee_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          <option value="">Select Employee</option>
          @foreach($employees as $emp)
            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Date</label>
        <input type="date" name="date" id="edit_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Check In</label>
          <input type="time" name="check_in" id="edit_check_in" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
        </div>
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Check Out</label>
          <input type="time" name="check_out" id="edit_check_out" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
        </div>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Status</label>
        <select name="status" id="edit_status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          <option value="present">Present</option>
          <option value="absent">Absent</option>
          <option value="half_day">Half Day</option>
          <option value="late">Late</option>
          <option value="early_leave">Early Leave</option>
        </select>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Notes</label>
        <textarea name="notes" id="edit_notes" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;" placeholder="Optional notes..."></textarea>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeEditAttendanceModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
        <button type="submit" style="padding: 10px 20px; border: none; background: #3b82f6; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Update Attendance</button>
      </div>
    </form>
  </div>
</div>

<script>
// Quick edit keyboard shortcut - Ctrl+Shift+E on time cell
let selectedTimeCell = null;

document.addEventListener('DOMContentLoaded', function() {
  // Add click listener to time cells to select them
  document.querySelectorAll('.time-cell').forEach(cell => {
    cell.addEventListener('click', function() {
      // Remove previous selection
      if (selectedTimeCell) {
        selectedTimeCell.style.outline = '';
      }
      // Select this cell (invisible to others)
      selectedTimeCell = this;
    });
  });
  
  // Keyboard shortcut: Ctrl+Shift+E for quick time edit
  document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.shiftKey && e.key === 'E') {
      e.preventDefault();
      
      if (selectedTimeCell) {
        const attendanceId = selectedTimeCell.getAttribute('data-attendance-id');
        const checkIn = selectedTimeCell.getAttribute('data-check-in');
        const checkOut = selectedTimeCell.getAttribute('data-check-out');
        
        openTimeEdit(attendanceId, checkIn, checkOut);
      }
    }
  });
});

function openTimeEdit(attendanceId, checkIn, checkOut) {
  document.getElementById('edit_attendance_id').value = attendanceId;
  document.getElementById('edit_check_in').value = checkIn;
  document.getElementById('edit_check_out').value = checkOut || '';
  
  document.getElementById('timeEditModal').style.display = 'flex';
  
  setTimeout(() => {
    document.getElementById('edit_check_in').focus();
  }, 100);
}

function closeTimeEditModal() {
  document.getElementById('timeEditModal').style.display = 'none';
  document.getElementById('timeEditForm').reset();
  selectedTimeCell = null;
}

function submitTimeEdit(event) {
  event.preventDefault();
  
  const attendanceId = document.getElementById('edit_attendance_id').value;
  const checkIn = document.getElementById('edit_check_in').value;
  const checkOut = document.getElementById('edit_check_out').value;
  
  fetch(`{{ url('attendance') }}/${attendanceId}/quick-edit`, {
    method: 'GET',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const attendance = data.attendance;
      
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('employee_id', attendance.employee_id);
      formData.append('date', attendance.date);
      formData.append('status', attendance.status);
      formData.append('notes', attendance.notes || '');
      formData.append('check_in', checkIn);
      if (checkOut) {
        formData.append('check_out', checkOut);
      }
      
      fetch(`{{ url('attendance') }}/${attendanceId}/quick-update`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          closeTimeEditModal();
          setTimeout(() => location.reload(), 500);
        } else {
          alert('Update failed');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Update failed');
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Failed to load data');
  });
}

// Quick Edit Time Functions
function quickEditTime(attendanceId, fieldType, currentTime) {
  document.getElementById('quick_attendance_id').value = attendanceId;
  document.getElementById('quick_field_type').value = fieldType;
  document.getElementById('quick_time_value').value = currentTime;
  
  // Update label based on field type
  const label = fieldType === 'check_in' ? 'Check In Time' : 'Check Out Time';
  document.getElementById('quick_time_label').textContent = label;
  
  // Show modal
  document.getElementById('quickEditTimeModal').style.display = 'flex';
  
  // Focus on time input
  setTimeout(() => {
    document.getElementById('quick_time_value').focus();
  }, 100);
}

function closeQuickEditTimeModal() {
  document.getElementById('quickEditTimeModal').style.display = 'none';
  document.getElementById('quickEditTimeForm').reset();
}

function submitQuickEditTime(event) {
  event.preventDefault();
  
  const attendanceId = document.getElementById('quick_attendance_id').value;
  const fieldType = document.getElementById('quick_field_type').value;
  const timeValue = document.getElementById('quick_time_value').value;
  
  // Fetch current attendance data first
  fetch(`{{ url('attendance') }}/${attendanceId}/edit`, {
    method: 'GET',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const attendance = data.attendance;
      
      // Prepare form data with all required fields
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('employee_id', attendance.employee_id);
      formData.append('date', attendance.date);
      formData.append('status', attendance.status);
      formData.append('notes', attendance.notes || '');
      
      // Update the specific time field
      if (fieldType === 'check_in') {
        formData.append('check_in', timeValue);
        // Keep existing check_out if available
        if (attendance.check_out) {
          const checkOutTime = typeof attendance.check_out === 'string' 
            ? attendance.check_out.split(' ')[1].substring(0, 5)
            : attendance.check_out.date.split(' ')[1].substring(0, 5);
          formData.append('check_out', checkOutTime);
        }
      } else {
        // Keep existing check_in
        const checkInTime = typeof attendance.check_in === 'string'
          ? attendance.check_in.split(' ')[1].substring(0, 5)
          : attendance.check_in.date.split(' ')[1].substring(0, 5);
        formData.append('check_in', checkInTime);
        formData.append('check_out', timeValue);
      }
      
      // Submit update
      fetch(`{{ url('attendance') }}/${attendanceId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          if (typeof toastr !== 'undefined') {
            toastr.success('Time updated successfully!');
          } else {
            alert('Time updated successfully!');
          }
          closeQuickEditTimeModal();
          setTimeout(() => location.reload(), 800);
        } else {
          if (typeof toastr !== 'undefined') {
            toastr.error(data.message || 'Error updating time');
          } else {
            alert(data.message || 'Error updating time');
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        if (typeof toastr !== 'undefined') {
          toastr.error('Error updating time');
        } else {
          alert('Error updating time');
        }
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error loading attendance data');
    } else {
      alert('Error loading attendance data');
    }
  });
}

function editAttendance(id) {
  // Fetch attendance data
  fetch(`{{ url('attendance') }}/${id}/edit`, {
    method: 'GET',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log('Attendance data:', data); // Debug log
    
    if (data.success) {
      const attendance = data.attendance;
      
      // Populate edit modal
      document.getElementById('edit_attendance_id').value = attendance.id;
      document.getElementById('edit_employee_id').value = attendance.employee_id;
      
      // Parse date - handle both string and object formats
      let dateValue = '';
      if (typeof attendance.date === 'string') {
        dateValue = attendance.date.split(' ')[0]; // Extract date part from string
      } else if (attendance.date && attendance.date.date) {
        dateValue = attendance.date.date.split(' ')[0]; // Extract from Carbon object
      }
      document.getElementById('edit_date').value = dateValue;
      
      // Extract time from datetime - handle both string and object formats
      let checkIn = '';
      let checkOut = '';
      
      if (attendance.check_in) {
        if (typeof attendance.check_in === 'string') {
          const parts = attendance.check_in.split(' ');
          checkIn = parts.length > 1 ? parts[1].substring(0, 5) : '';
        } else if (attendance.check_in.date) {
          const parts = attendance.check_in.date.split(' ');
          checkIn = parts.length > 1 ? parts[1].substring(0, 5) : '';
        }
      }
      
      if (attendance.check_out) {
        if (typeof attendance.check_out === 'string') {
          const parts = attendance.check_out.split(' ');
          checkOut = parts.length > 1 ? parts[1].substring(0, 5) : '';
        } else if (attendance.check_out.date) {
          const parts = attendance.check_out.date.split(' ');
          checkOut = parts.length > 1 ? parts[1].substring(0, 5) : '';
        }
      }
      
      document.getElementById('edit_check_in').value = checkIn;
      document.getElementById('edit_check_out').value = checkOut;
      document.getElementById('edit_status').value = attendance.status;
      document.getElementById('edit_notes').value = attendance.notes || '';
      
      // Show edit modal
      document.getElementById('editAttendanceModal').style.display = 'flex';
    } else {
      if (typeof toastr !== 'undefined') {
        toastr.error(data.message || 'Error loading attendance data');
      } else {
        alert(data.message || 'Error loading attendance data');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error loading attendance data: ' + error.message);
    } else {
      alert('Error loading attendance data: ' + error.message);
    }
  });
}

function closeEditAttendanceModal() {
  document.getElementById('editAttendanceModal').style.display = 'none';
  document.getElementById('editAttendanceForm').reset();
}

function submitEditAttendance(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  const attendanceId = document.getElementById('edit_attendance_id').value;
  
  // Add _method for PUT request
  formData.append('_method', 'PUT');
  
  fetch(`{{ url('attendance') }}/${attendanceId}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      toastr.success(data.message || 'Attendance updated successfully!');
      closeEditAttendanceModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      toastr.error(data.message || 'Error updating attendance');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    toastr.error('Error updating attendance');
  });
}

function deleteAttendance(id) {
  if (confirm('Are you sure you want to delete this attendance record? This action cannot be undone.')) {
    // Use FormData with _method for DELETE
    const formData = new FormData();
    formData.append('_method', 'DELETE');
    
    fetch('{{ url("attendance") }}/' + id, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        if (typeof toastr !== 'undefined') {
          toastr.success('Attendance record deleted successfully!');
        } else {
          alert('Attendance record deleted successfully!');
        }
        setTimeout(() => location.reload(), 1000);
      } else {
        if (typeof toastr !== 'undefined') {
          toastr.error('Error deleting record: ' + (data.message || 'Unknown error'));
        } else {
          alert('Error deleting record: ' + (data.message || 'Unknown error'));
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      if (typeof toastr !== 'undefined') {
        toastr.error('Error deleting record: ' + error.message);
      } else {
        alert('Error deleting record: ' + error.message);
      }
    });
  }
}

function printAttendance(id) {
  // Open print view in new window
  window.open('{{ url("attendance") }}/' + id + '/print', '_blank');
}
</script>
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({ marginTop: '2px', marginLeft: '0px' });
            }, 0);
        }
    });
});
// Date format dd/mm/yy is sent directly to server - controller handles parsing
</script>
@endpush

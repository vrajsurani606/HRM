@extends('layouts.macos')
@section('page_title', 'Attendance Reports')

@section('content')
<div class="hrp-content">
  <!-- Filter Row -->
  <form method="GET" action="{{ route('attendance.report') }}" class="jv-filter" id="filterForm">
    <input type="date" name="start_date" class="filter-pill" placeholder="From : dd/mm/yyyy" value="{{ request('start_date') }}">
    <input type="date" name="end_date" class="filter-pill" placeholder="To : dd/mm/yyyy" value="{{ request('end_date') }}">
    
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
    
    <a href="{{ route('attendance.report') }}" class="filter-search" aria-label="Refresh">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>
    
    <div class="filter-right">
      <a href="{{ route('attendance.reports.export', request()->all()) }}" class="pill-btn pill-success">Export to Excel</a>
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
          <th style="width: 140px; text-align: center;">Action</th>
          <th style="width: 150px;">EMP Code</th>
          <th style="width: 250px;">EMPLOYEE</th>
          <th style="width: 380px;">Check IN & OUT</th>
          <th style="width: 100px; text-align: center;">Overtime</th>
          <th style="width: 120px; text-align: center;">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($attendances as $attendance)
        <tr>
          <td style="vertical-align: middle; padding: 14px;">
            <div>
              <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" style="cursor: pointer; width: 18px; height: 18px;" onclick="editAttendance({{ $attendance->id }})">
              <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" style="cursor: pointer; width: 18px; height: 18px;" onclick="deleteAttendance({{ $attendance->id }})">
              <img src="{{ asset('action_icon/print.svg') }}" alt="Print" style="cursor: pointer; width: 18px; height: 18px;" onclick="printAttendance({{ $attendance->id }})">
            </div>
          </td>
          <td style="vertical-align: middle;">{{ $attendance->employee->code ?? 'EMP/' . str_pad($attendance->employee->id ?? '000', 4, '0', STR_PAD_LEFT) }}</td>
          <td style="vertical-align: middle;">{{ $attendance->employee->name ?? 'N/A' }}</td>
          <td style="vertical-align: middle; padding: 12px 16px;">
            @php
              $checkIn = $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in) : null;
              $checkOut = $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out) : null;
              $standardCheckIn = \Carbon\Carbon::parse($attendance->date)->setTime(9, 30);
              $yellowThreshold = \Carbon\Carbon::parse($attendance->date)->setTime(9, 30); // After 9:30 = Yellow
              $redThreshold = \Carbon\Carbon::parse($attendance->date)->setTime(10, 0); // After 10:00 = Red
              $standardCheckOut = \Carbon\Carbon::parse($attendance->date)->setTime(18, 30);
              
              // Determine check-in color
              $checkInColor = '#10b981'; // Default green
              if ($checkIn) {
                  if ($checkIn->greaterThan($redThreshold)) {
                      $checkInColor = '#ef4444'; // Red - Very late (after 10:00)
                  } elseif ($checkIn->greaterThan($yellowThreshold)) {
                      $checkInColor = '#f59e0b'; // Yellow/Orange - Late (after 9:30)
                  }
              }
              
              // Determine check-out color - Green if after 6:30 PM
              $checkOutColor = '#10b981'; // Default green (on time or overtime)
              $overtimeText = '';
              if ($checkOut) {
                  if ($checkOut->greaterThan($standardCheckOut)) {
                      // Calculate overtime
                      $overtimeMinutes = $checkOut->diffInMinutes($standardCheckOut);
                      $overtimeHours = floor($overtimeMinutes / 60);
                      $overtimeMins = $overtimeMinutes % 60;
                      if ($overtimeHours > 0 || $overtimeMins > 0) {
                          $overtimeText = sprintf('%dh %dm', $overtimeHours, $overtimeMins);
                      }
                  }
              }
            @endphp
            
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
              @if($overtimeText)
                <div style="color:#10b981; font-size:10px; font-weight:600; margin-bottom:3px; line-height:1;">{{ $overtimeText }}</div>
              @endif
              <div style="display: flex; justify-content: center; align-items: center; white-space: nowrap;">
                @if($checkIn)
                  <span style="color:{{ $checkInColor }}; font-weight:600; font-size:14px;">{{ $checkIn->format('h:i A') }}</span>
                @else
                  <span style="color:#9ca3af;">--</span>
                @endif
                
                @if($checkIn && $checkOut)
                  <span style="color:#d1d5db; margin:0 8px; font-weight:300; font-size:14px;">———</span>
                  @php
                    $diff = $checkIn->diff($checkOut);
                    $totalHours = $diff->h + ($diff->days * 24);
                    $minutes = $diff->i;
                  @endphp
                  <span style="color:#9ca3af; font-size:12px; font-weight:500;">{{ sprintf('%02dh %02dm', $totalHours, $minutes) }}</span>
                  <span style="color:#d1d5db; margin:0 8px; font-weight:300; font-size:14px;">———</span>
                @endif
                
                @if($checkOut)
                  <span style="color:{{ $checkOutColor }}; font-weight:600; font-size:14px;">{{ $checkOut->format('h:i A') }}</span>
                @else
                  <span style="color:#9ca3af;">--</span>
                @endif
              </div>
            </div>
          </td>
          <td style="vertical-align: middle; text-align: center;">
            <span style="font-weight:600;color:#6b7280">{{ $attendance->calculateOvertime() }}</span>
          </td>
          <td style="vertical-align: middle; text-align: center; padding: 12px;">
            @php
              $statusColor = match($attendance->status) {
                'present' => '#10b981',
                'absent' => '#ef4444',
                'half_day' => '#f59e0b',
                'late' => '#f59e0b',
                'early_leave' => '#f59e0b',
                default => '#6b7280',
              };
            @endphp
            <span style="color: {{ $statusColor }}; font-weight: 600; font-size: 14px;">{{ $attendance->getStatusText() }}</span>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align: center; padding: 40px; color: #9ca3af;">
            <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 12px; opacity: 0.5;">
              <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <p style="font-weight: 600; margin: 0;">No attendance records found</p>
            <p style="font-size: 14px; margin: 8px 0 0 0;">Try adjusting your filters</p>
          </td>
        </tr>
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

<script>
function editAttendance(id) {
  // Redirect to edit page or open modal
  window.location.href = '/attendance/' + id + '/edit';
}

function deleteAttendance(id) {
  if (confirm('Are you sure you want to delete this attendance record?')) {
    fetch('/attendance/' + id, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        toastr.success('Attendance record deleted successfully!');
        location.reload();
      } else {
        toastr.error('Error deleting record: ' + (data.message || 'Unknown error'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error deleting record');
    });
  }
}

function printAttendance(id) {
  // Open print view in new window
  window.open('/attendance/' + id + '/print', '_blank');
}
</script>
@endsection



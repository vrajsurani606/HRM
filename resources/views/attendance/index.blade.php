@extends('layouts.macos')
@section('page_title', 'Attendance Management')

@section('content')
<div class="inquiry-index-container">
  <!-- Header Actions -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding: 0 4px;">
    <div>
      <h2 style="margin: 0 0 4px 0; font-size: 24px; font-weight: 700; color: #0f172a;">Attendance Dashboard</h2>
      <p style="margin: 0; color: #64748b; font-size: 14px;">{{ now()->format('l, F j, Y') }}</p>
    </div>
    <div style="display: flex; gap: 10px;">
      @if(!$attendance || !$attendance->check_in)
        <button onclick="openCheckInModal()" class="pill-btn pill-success">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
          </svg>
          Check In
        </button>
      @elseif($attendance->check_in && !$attendance->check_out)
        <button onclick="openCheckOutModal()" class="pill-btn" style="background: #ef4444; color: white;">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 6px;">
            <path d="M19 13H5v-2h14v2z"/>
          </svg>
          Check Out
        </button>
      @endif
      <a href="{{ route('attendance.history') }}" class="pill-btn" style="background: #3b82f6; color: white;">View History</a>
    </div>
  </div>

  <!-- Current Status Card -->
  @if($attendance && $attendance->check_in)
  <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #0f172a;">Today's Attendance</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      <div style="padding: 16px; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #10b981;">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Check In</div>
        <div style="font-size: 20px; font-weight: 700; color: #0f172a;">{{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}</div>
      </div>
      @if($attendance->check_out)
      <div style="padding: 16px; background: #fef2f2; border-radius: 8px; border-left: 4px solid #ef4444;">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Check Out</div>
        <div style="font-size: 20px; font-weight: 700; color: #0f172a;">{{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}</div>
      </div>
      <div style="padding: 16px; background: #eff6ff; border-radius: 8px; border-left: 4px solid #3b82f6;">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Total Hours</div>
        <div style="font-size: 20px; font-weight: 700; color: #0f172a;">{{ $attendance->total_working_hours ?? 'N/A' }}</div>
      </div>
      @else
      <div style="padding: 16px; background: #fef3c7; border-radius: 8px; border-left: 4px solid #f59e0b;">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Duration</div>
        <div style="font-size: 20px; font-weight: 700; color: #0f172a;">{{ now()->diff(\Carbon\Carbon::parse($attendance->check_in))->format('%h:%I') }}</div>
      </div>
      @endif
    </div>
  </div>
  @endif

  <!-- Recent Attendance Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th style="text-align: center;">Date</th>
          <th style="text-align: center;">Check In</th>
          <th style="text-align: center;">Check Out</th>
          <th style="text-align: center;">Working Hours</th>
          <th style="text-align: center;">Status</th>
          <th style="text-align: center;">Notes</th>
        </tr>
      </thead>
      <tbody>
        @forelse($attendanceHistory as $record)
        <tr>
          <td style="padding: 12px 8px; text-align: center; font-weight: 600; color: #1f2937;">
            {{ $record->date->format('d M, Y') }}
          </td>
          <td style="padding: 12px 8px; text-align: center; color: #1f2937;">
            {{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '--:--' }}
          </td>
          <td style="padding: 12px 8px; text-align: center; color: #1f2937;">
            {{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : '--:--' }}
          </td>
          <td style="padding: 12px 8px; text-align: center; font-weight: 600; color: #1f2937;">
            {{ $record->total_working_hours ?? '--:--' }}
          </td>
          <td style="padding: 12px 8px; text-align: center;">
            @php
              $statusColors = [
                'present' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                'half_day' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'leave' => ['bg' => '#dbeafe', 'text' => '#0c4a6e'],
                'absent' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
              ];
              $statusColor = $statusColors[$record->status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
            @endphp
            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
              {{ ucfirst(str_replace('_', ' ', $record->status)) }}
            </span>
          </td>
          <td style="padding: 12px 8px; text-align: center; color: #6b7280; font-size: 13px;">
            {{ $record->notes ? \Str::limit($record->notes, 30) : '-' }}
          </td>
        </tr>
        @empty
          <x-empty-state 
              colspan="6" 
              title="No attendance records found" 
              message="Check in to start tracking your attendance"
          />
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Check In Modal -->
<div id="checkInModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 16px; padding: 40px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
    <h2 style="margin: 0 0 20px 0; font-size: 24px; font-weight: 700; color: #0f172a;">Check In</h2>
    <form action="{{ route('attendance.check-in') }}" method="POST">
      @csrf
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #0f172a;">Notes (Optional)</label>
        <textarea name="notes" rows="3" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;" placeholder="Add any notes..."></textarea>
      </div>
      <div style="display: flex; gap: 12px; justify-content: flex-end;">
        <button type="button" onclick="closeCheckInModal()" style="padding: 12px 24px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #0f172a; font-size: 14px;">Cancel</button>
        <button type="submit" style="padding: 12px 24px; border: none; background: #10b981; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px;">Check In</button>
      </div>
    </form>
  </div>
</div>

<!-- Check Out Modal -->
<div id="checkOutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 16px; padding: 40px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
    <h2 style="margin: 0 0 20px 0; font-size: 24px; font-weight: 700; color: #0f172a;">Check Out</h2>
    <form action="{{ route('attendance.check-out') }}" method="POST">
      @csrf
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #0f172a;">End of Day Notes (Optional)</label>
        <textarea name="notes" rows="3" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;" placeholder="How was your day? Any notes for today..."></textarea>
      </div>
      <div style="display: flex; gap: 12px; justify-content: flex-end;">
        <button type="button" onclick="closeCheckOutModal()" style="padding: 12px 24px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #0f172a; font-size: 14px;">Cancel</button>
        <button type="submit" style="padding: 12px 24px; border: none; background: #ef4444; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px;">Check Out</button>
      </div>
    </form>
  </div>
</div>

<script>
function openCheckInModal() {
  document.getElementById('checkInModal').style.display = 'flex';
}

function closeCheckInModal() {
  document.getElementById('checkInModal').style.display = 'none';
}

function openCheckOutModal() {
  document.getElementById('checkOutModal').style.display = 'flex';
}

function closeCheckOutModal() {
  document.getElementById('checkOutModal').style.display = 'none';
}
</script>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('attendance.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Attendance Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Attendance Dashboard</span>
@endsection

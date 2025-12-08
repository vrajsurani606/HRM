@extends('layouts.macos')
@section('page_title', 'Leave Management')

@section('content')
<div class="hrp-content">
  <!-- Filters -->
  <form method="GET" action="{{ route('leave-approval.index') }}" class="jv-filter">
    <input type="text" name="start_date" class="filter-pill date-picker" placeholder="From : dd/mm/yyyy" value="{{ request('start_date') }}" autocomplete="off">
    <input type="text" name="end_date" class="filter-pill date-picker" placeholder="To : dd/mm/yyyy" value="{{ request('end_date') }}" autocomplete="off">
    
    <select name="employee_id" class="filter-pill">
      <option value="">All Employee</option>
      @foreach($employees as $emp)
        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
      @endforeach
    </select>
    
    <select name="status" class="filter-pill">
      <option value="">All Status</option>
      <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
      <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
    
    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>
    
    <a href="{{ route('leave-approval.index') }}" class="filter-search" aria-label="Refresh">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>

    <div class="filter-right">
      @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.create leave approval'))
        <button type="button" class="pill-btn pill-success" onclick="openAddLeaveModal()" style="display: flex; align-items: center; gap: 8px;">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
          </svg>
          Add Leave
        </button>
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
      .leave-type {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
      }
      .leave-type--casual { background: #dbeafe; color: #1e40af; }
      .leave-type--medical { background: #fee2e2; color: #991b1b; }
      .leave-type--personal { background: #fef3c7; color: #92400e; }
      .leave-type--company_holiday { background: #fbbf24; color: #78350f; }
    </style>
    <table>
      <thead>
        <tr>
          <th style="width: 140px; text-align: center;">Action</th>
          <th style="width: 130px;">EMP Code</th>
          <th style="width: 180px;">EMPLOYEE</th>
          <th style="width: 280px;">Start to End Date</th>
          <th style="width: 100px; text-align: center;">Duration</th>
          <th style="width: 180px;">Leave Type</th>
          <th style="width: 250px;">Leave Reason</th>
          <th style="width: 100px; text-align: center;">Status</th>
          <th style="width: 180px;">Applied Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($leaves as $leave)
        <tr>
          <td style="vertical-align: middle; padding: 14px;">
            <div>
              @if($leave->status == 'pending')
                <!-- Approve/Reject buttons for pending leaves -->
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.approve leave'))
                  <img src="{{ asset('action_icon/approve.svg') }}" alt="Approve" style="cursor: pointer; width: 20px; height: 20px;" onclick="approveLeave({{ $leave->id }})">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.reject leave'))
                  <img src="{{ asset('action_icon/reject.svg') }}" alt="Reject" style="cursor: pointer; width: 20px; height: 20px;" onclick="rejectLeave({{ $leave->id }})">
                @endif
              @else
                <!-- Edit/Delete buttons for approved/rejected leaves -->
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.edit leave approval'))
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" style="cursor: pointer; width: 18px; height: 18px;" onclick="editLeave({{ $leave->id }})">
                @endif
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.delete leave approval'))
                  <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" style="cursor: pointer; width: 18px; height: 18px;" onclick="deleteLeave({{ $leave->id }})">
                @endif
              @endif
            </div>
          </td>
          <td style="vertical-align: middle; padding: 14px 16px;">{{ $leave->employee->code ?? 'N/A' }}</td>
          <td style="vertical-align: middle; padding: 14px 16px;">{{ $leave->employee->name ?? 'N/A' }}</td>
          <td style="vertical-align: middle; padding: 14px 16px;">
            {{ \Carbon\Carbon::parse($leave->start_date)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}
          </td>
          <td style="vertical-align: middle; padding: 14px; text-align: center;">{{ $leave->total_days }} Day{{ $leave->total_days > 1 ? 's' : '' }}</td>
          <td style="vertical-align: middle; padding: 14px;">
            <span class="leave-type leave-type--{{ strtolower($leave->leave_type) }}">
              {{ ucfirst(str_replace('_', ' ', $leave->leave_type)) }}
              @if($leave->is_paid ?? true)
                @php
                  $yearlyUsed = \App\Models\Leave::where('employee_id', $leave->employee_id)
                    ->where('is_paid', true)
                    ->whereYear('start_date', now()->year)
                    ->where('status', '!=', 'rejected')
                    ->sum('total_days');
                @endphp
                <span style="font-size: 10px; opacity: 0.8;">(Paid {{ $yearlyUsed }}/12)</span>
              @else
                <span style="font-size: 10px; opacity: 0.8;">(Unpaid)</span>
              @endif
            </span>
          </td>
          <td style="vertical-align: middle; padding: 14px 16px;">{{ $leave->reason ?? '-' }}</td>
          <td style="vertical-align: middle; text-align: center; padding: 14px;">
            @php
              $statusColor = match($leave->status) {
                'approved' => '#10b981',
                'rejected' => '#ef4444',
                'pending' => '#f59e0b',
                default => '#6b7280',
              };
            @endphp
            <span style="color: {{ $statusColor }}; font-weight: 600; font-size: 14px;">{{ ucfirst($leave->status) }}</span>
          </td>
          <td style="vertical-align: middle; padding: 14px 16px;">{{ $leave->created_at->format('d M, Y, h:i A') }}</td>
        </tr>
        @empty
          <x-empty-state 
              colspan="9" 
              title="No leave requests found" 
              message="Try adjusting your filters or add a new leave request"
          />
        @endforelse
      </tbody>
    </table>
  </div>

  @if($leaves->hasPages())
  <div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $leaves->links() }}
  </div>
  @endif
</div>

<!-- Edit Leave Modal -->
<div id="editLeaveModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto;">
    <h3 style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Edit Leave Request</h3>
    
    <form id="editLeaveForm" onsubmit="submitEditLeave(event)">
      <input type="hidden" name="leave_id" id="edit_leave_id">
      
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
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Leave Type</label>
        <select name="leave_type" id="edit_leave_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="updateEditLeaveInfo()">
          <option value="">Select Leave Type</option>
          <option value="casual" data-is-paid="1">Casual Leave (Paid)</option>
          <option value="medical" data-is-paid="1">Medical Leave (Paid)</option>
          <option value="company_holiday" data-is-paid="1">Company Holiday (Paid)</option>
          <option value="personal" data-is-paid="0">Personal Leave (Unpaid)</option>
        </select>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Start Date</label>
          <input type="date" name="start_date" id="edit_start_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="calculateEditModalDays()">
        </div>
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">End Date</label>
          <input type="date" name="end_date" id="edit_end_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="calculateEditModalDays()">
        </div>
      </div>

      <!-- Calculated Days Display -->
      <div id="edit_calculatedDays" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 16px; margin-bottom: 15px; display: none; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
        <div style="display: flex; align-items: center; justify-content: space-between; color: white;">
          <div>
            <div style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">
              <i class="fa fa-calendar"></i> Calculated Leave Days
            </div>
            <div style="font-size: 28px; font-weight: 800; line-height: 1;">
              <span id="edit_daysCount">0</span> <span style="font-size: 16px; font-weight: 600;">days</span>
            </div>
          </div>
          <div style="text-align: right;">
            <div style="font-size: 10px; opacity: 0.8; margin-bottom: 4px;">Auto-Calculated</div>
            <div style="font-size: 12px; font-weight: 600;">
              <i class="fa fa-check-circle"></i> Sundays Excluded
            </div>
          </div>
        </div>
        <div id="edit_dateRangeDisplay" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.2); font-size: 11px; color: rgba(255,255,255,0.9);">
          <i class="fa fa-arrow-right"></i> <span id="edit_dateRangeText"></span>
        </div>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Total Days</label>
        <input type="number" name="total_days" id="edit_total_days" step="0.5" min="0.5" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" placeholder="Auto-calculated or enter manually (e.g., 0.5, 1, 3.5)">
        <small style="color: #6b7280; font-size: 12px;">Auto-calculated from dates (editable for half-days like 0.5, 1.5, 3.5)</small>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Reason</label>
        <textarea name="reason" id="edit_reason" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;" placeholder="Please provide a reason for the leave request..."></textarea>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Status</label>
        <select name="status" id="edit_status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          <option value="pending">Pending</option>
          <option value="approved">Approved</option>
          <option value="rejected">Rejected</option>
        </select>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeEditLeaveModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
        <button type="submit" style="padding: 10px 20px; border: none; background: #3b82f6; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Update Leave</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Leave Modal -->
<div id="addLeaveModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h3 style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Add Leave Request</h3>
    
    <form id="addLeaveForm" onsubmit="submitLeave(event)">
      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Employee</label>
        <select name="employee_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" {{ $employees->count() == 1 ? 'readonly' : '' }}>
          <option value="">Select Employee</option>
          @foreach($employees as $emp)
            <option value="{{ $emp->id }}" {{ $employees->count() == 1 ? 'selected' : '' }}>{{ $emp->name }}</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Leave Type</label>
        <select name="leave_type" id="add_leave_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="updateLeaveInfo()">
          <option value="">Select Leave Type</option>
          <option value="casual" data-is-paid="1">Casual Leave (Paid)</option>
          <option value="medical" data-is-paid="1">Medical Leave (Paid)</option>
          <option value="company_holiday" data-is-paid="1">Company Holiday (Paid)</option>
          <option value="personal" data-is-paid="0">Personal Leave (Unpaid)</option>
        </select>
        <small id="leaveTypeInfo" style="display: block; margin-top: 6px; font-size: 12px; color: #6b7280;"></small>
        <div id="paid_leave_info" style="display: none; margin-top: 8px; padding: 8px; background: #f0f9ff; border-radius: 6px; font-size: 12px; color: #0c4a6e;">
          <strong>Paid Leave Balance:</strong> <span id="paid_leave_count">-</span>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Start Date</label>
          <input type="date" name="start_date" id="modal_start_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="calculateModalDays()">
        </div>
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">End Date</label>
          <input type="date" name="end_date" id="modal_end_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="calculateModalDays()">
        </div>
      </div>

      <!-- Calculated Days Display -->
      <div id="modal_calculatedDays" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 16px; margin-bottom: 15px; display: none; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
        <div style="display: flex; align-items: center; justify-content: space-between; color: white;">
          <div>
            <div style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">
              <i class="fa fa-calendar"></i> Calculated Leave Days
            </div>
            <div style="font-size: 28px; font-weight: 800; line-height: 1;">
              <span id="modal_daysCount">0</span> <span style="font-size: 16px; font-weight: 600;">days</span>
            </div>
          </div>
          <div style="text-align: right;">
            <div style="font-size: 10px; opacity: 0.8; margin-bottom: 4px;">Auto-Calculated</div>
            <div style="font-size: 12px; font-weight: 600;">
              <i class="fa fa-check-circle"></i> Sundays Excluded
            </div>
          </div>
        </div>
        <div id="modal_dateRangeDisplay" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.2); font-size: 11px; color: rgba(255,255,255,0.9);">
          <i class="fa fa-arrow-right"></i> <span id="modal_dateRangeText"></span>
        </div>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Total Days</label>
        <input type="number" name="total_days" id="modal_total_days" step="0.5" min="0.5" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" placeholder="Auto-calculated or enter manually (e.g., 0.5, 1, 3.5)">
        <small style="color: #6b7280; font-size: 12px;">Auto-calculated from dates (editable for half-days like 0.5, 1.5, 3.5)</small>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Reason</label>
        <textarea name="reason" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;" placeholder="Please provide a reason for the leave request..."></textarea>
      </div>

      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeAddLeaveModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
        <button type="submit" style="padding: 10px 20px; border: none; background: #10b981; color: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Submit Leave</button>
      </div>
    </form>
  </div>
</div>

<script>
function openAddLeaveModal() {
  document.getElementById('addLeaveModal').style.display = 'flex';
}

function closeAddLeaveModal() {
  document.getElementById('addLeaveModal').style.display = 'none';
  document.getElementById('addLeaveForm').reset();
  document.getElementById('modal_calculatedDays').style.display = 'none';
}

function closeEditLeaveModal() {
  document.getElementById('editLeaveModal').style.display = 'none';
  document.getElementById('editLeaveForm').reset();
  document.getElementById('edit_calculatedDays').style.display = 'none';
}

function calculateEditModalDays() {
  const startDateInput = document.getElementById('edit_start_date');
  const endDateInput = document.getElementById('edit_end_date');
  const calculatedDays = document.getElementById('edit_calculatedDays');
  const daysCount = document.getElementById('edit_daysCount');
  const totalDaysInput = document.getElementById('edit_total_days');
  const dateRangeText = document.getElementById('edit_dateRangeText');
  
  if (!startDateInput || !endDateInput) {
    return;
  }
  
  if (!startDateInput.value || !endDateInput.value) {
    if (calculatedDays) calculatedDays.style.display = 'none';
    return;
  }

  // Set end date minimum to start date
  endDateInput.min = startDateInput.value;
  if (endDateInput.value < startDateInput.value) {
    endDateInput.value = startDateInput.value;
  }

  try {
    // Parse dates - handle both formats: yyyy-mm-dd and dd/mm/yyyy
    let start, end;
    
    if (startDateInput.value.includes('/')) {
      // Format: dd/mm/yyyy
      const startParts = startDateInput.value.split('/');
      const endParts = endDateInput.value.split('/');
      start = new Date(parseInt(startParts[2]), parseInt(startParts[1]) - 1, parseInt(startParts[0]));
      end = new Date(parseInt(endParts[2]), parseInt(endParts[1]) - 1, parseInt(endParts[0]));
    } else {
      // Format: yyyy-mm-dd
      const startParts = startDateInput.value.split('-');
      const endParts = endDateInput.value.split('-');
      start = new Date(parseInt(startParts[0]), parseInt(startParts[1]) - 1, parseInt(startParts[2]));
      end = new Date(parseInt(endParts[0]), parseInt(endParts[1]) - 1, parseInt(endParts[2]));
    }
    
    // Validate dates
    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
      if (calculatedDays) calculatedDays.style.display = 'none';
      return;
    }
    
    // Format dates for display
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const startFormatted = `${months[start.getMonth()]} ${start.getDate()}, ${start.getFullYear()}`;
    const endFormatted = `${months[end.getMonth()]} ${end.getDate()}, ${end.getFullYear()}`;
    
    // Calculate business days (excluding only Sunday)
    let totalDays = 0;
    let weekendDays = 0;
    
    const currentDate = new Date(start);
    while (currentDate <= end) {
      const dayOfWeek = currentDate.getDay();
      // Skip only Sunday (0 = Sunday)
      if (dayOfWeek !== 0) {
        totalDays++;
      } else {
        weekendDays++;
      }
      currentDate.setDate(currentDate.getDate() + 1);
    }
    
    // Update display
    if (daysCount) daysCount.textContent = totalDays;
    if (totalDaysInput) totalDaysInput.value = totalDays;
    
    // Show date range with Sunday info
    let rangeText = `${startFormatted} → ${endFormatted}`;
    if (weekendDays > 0) {
      rangeText += ` (${weekendDays} Sunday${weekendDays > 1 ? 's' : ''} excluded)`;
    }
    if (dateRangeText) dateRangeText.textContent = rangeText;
    
    if (calculatedDays) {
      calculatedDays.style.display = 'block';
      
      // Add animation
      calculatedDays.style.animation = 'none';
      setTimeout(() => {
        calculatedDays.style.animation = 'slideInModal 0.3s ease-out';
      }, 10);
    }
  } catch (error) {
    console.error('Date calculation error:', error);
    if (calculatedDays) calculatedDays.style.display = 'none';
  }
}

function updateEditLeaveInfo() {
  const leaveTypeSelect = document.getElementById('edit_leave_type');
  const selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];
  
  if (leaveTypeSelect.value) {
    const isPaid = selectedOption.getAttribute('data-is-paid') === '1';
    // You can add additional info display here if needed
  }
}

function submitEditLeave(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  const leaveId = document.getElementById('edit_leave_id').value;
  
  // Convert dates from dd/mm/yyyy to yyyy-mm-dd format if needed
  const startDate = formData.get('start_date');
  const endDate = formData.get('end_date');
  
  if (startDate && startDate.includes('/')) {
    const parts = startDate.split('/');
    formData.set('start_date', `${parts[2]}-${parts[1]}-${parts[0]}`);
  }
  
  if (endDate && endDate.includes('/')) {
    const parts = endDate.split('/');
    formData.set('end_date', `${parts[2]}-${parts[1]}-${parts[0]}`);
  }
  
  // Automatically set is_paid based on leave_type
  const leaveType = formData.get('leave_type');
  const paidTypes = ['casual', 'medical', 'company_holiday'];
  const isPaid = paidTypes.includes(leaveType) ? '1' : '0';
  formData.append('is_paid', isPaid);
  
  // Ensure total_days is sent as decimal
  const totalDays = parseFloat(formData.get('total_days'));
  formData.set('total_days', totalDays);
  
  // Add _method for PUT request
  formData.append('_method', 'PUT');
  
  fetch(`{{ url('leave-approval') }}/${leaveId}`, {
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
        toastr.success(data.message || 'Leave updated successfully!');
      } else {
        alert(data.message || 'Leave updated successfully!');
      }
      closeEditLeaveModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      if (typeof toastr !== 'undefined') {
        toastr.error(data.message || 'Error updating leave');
      } else {
        alert(data.message || 'Error updating leave');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error updating leave');
    } else {
      alert('Error updating leave');
    }
  });
}

function calculateModalDays() {
  console.log('calculateModalDays called'); // Debug
  
  const startDateInput = document.getElementById('modal_start_date');
  const endDateInput = document.getElementById('modal_end_date');
  const calculatedDays = document.getElementById('modal_calculatedDays');
  const daysCount = document.getElementById('modal_daysCount');
  const totalDaysInput = document.getElementById('modal_total_days');
  const dateRangeText = document.getElementById('modal_dateRangeText');
  
  console.log('Start date:', startDateInput?.value, 'End date:', endDateInput?.value); // Debug
  
  if (!startDateInput || !endDateInput) {
    console.log('Date inputs not found');
    return;
  }
  
  if (!startDateInput.value || !endDateInput.value) {
    console.log('Date values empty');
    if (calculatedDays) calculatedDays.style.display = 'none';
    return;
  }

  // Set end date minimum to start date
  endDateInput.min = startDateInput.value;
  if (endDateInput.value < startDateInput.value) {
    endDateInput.value = startDateInput.value;
  }

  try {
    // Parse dates - handle both formats: yyyy-mm-dd and dd/mm/yyyy
    let start, end;
    
    if (startDateInput.value.includes('/')) {
      // Format: dd/mm/yyyy
      const startParts = startDateInput.value.split('/');
      const endParts = endDateInput.value.split('/');
      start = new Date(parseInt(startParts[2]), parseInt(startParts[1]) - 1, parseInt(startParts[0]));
      end = new Date(parseInt(endParts[2]), parseInt(endParts[1]) - 1, parseInt(endParts[0]));
    } else {
      // Format: yyyy-mm-dd
      const startParts = startDateInput.value.split('-');
      const endParts = endDateInput.value.split('-');
      start = new Date(parseInt(startParts[0]), parseInt(startParts[1]) - 1, parseInt(startParts[2]));
      end = new Date(parseInt(endParts[0]), parseInt(endParts[1]) - 1, parseInt(endParts[2]));
    }
    
    console.log('Parsed dates:', start, end); // Debug
    
    // Validate dates
    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
      console.log('Invalid dates');
      if (calculatedDays) calculatedDays.style.display = 'none';
      return;
    }
    
    // Format dates for display
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const startFormatted = `${months[start.getMonth()]} ${start.getDate()}, ${start.getFullYear()}`;
    const endFormatted = `${months[end.getMonth()]} ${end.getDate()}, ${end.getFullYear()}`;
    
    // Calculate business days (excluding only Sunday)
    let totalDays = 0;
    let weekendDays = 0;
    
    const currentDate = new Date(start);
    while (currentDate <= end) {
      const dayOfWeek = currentDate.getDay();
      // Skip only Sunday (0 = Sunday)
      if (dayOfWeek !== 0) {
        totalDays++;
      } else {
        weekendDays++;
      }
      currentDate.setDate(currentDate.getDate() + 1);
    }
    
    console.log('Calculated days:', totalDays, 'Weekend days:', weekendDays); // Debug
    
    // Update display
    if (daysCount) daysCount.textContent = totalDays;
    if (totalDaysInput) totalDaysInput.value = totalDays;
    
    // Show date range with Sunday info
    let rangeText = `${startFormatted} → ${endFormatted}`;
    if (weekendDays > 0) {
      rangeText += ` (${weekendDays} Sunday${weekendDays > 1 ? 's' : ''} excluded)`;
    }
    if (dateRangeText) dateRangeText.textContent = rangeText;
    
    if (calculatedDays) {
      calculatedDays.style.display = 'block';
      
      // Add animation
      calculatedDays.style.animation = 'none';
      setTimeout(() => {
        calculatedDays.style.animation = 'slideInModal 0.3s ease-out';
      }, 10);
    }
  } catch (error) {
    console.error('Date calculation error:', error);
    if (calculatedDays) calculatedDays.style.display = 'none';
  }
}

// Add CSS animation for modal
if (!document.getElementById('modalAnimationStyle')) {
  const style = document.createElement('style');
  style.id = 'modalAnimationStyle';
  style.textContent = `
    @keyframes slideInModal {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  `;
  document.head.appendChild(style);
}

function updateLeaveInfo() {
  const leaveTypeSelect = document.getElementById('add_leave_type');
  const selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];
  const leaveTypeInfo = document.getElementById('leaveTypeInfo');
  const paidLeaveInfo = document.getElementById('paid_leave_info');
  const employeeId = document.querySelector('select[name="employee_id"]').value;
  
  if (leaveTypeSelect.value) {
    const isPaid = selectedOption.getAttribute('data-is-paid') === '1';
    
    if (isPaid) {
      leaveTypeInfo.innerHTML = '<i class="fa fa-check-circle" style="color: #10b981;"></i> This is a <strong>Paid Leave</strong>';
      leaveTypeInfo.style.color = '#10b981';
      
      // Show paid leave info and fetch balance
      if (employeeId) {
        paidLeaveInfo.style.display = 'block';
        fetchPaidLeaveBalance(employeeId);
      } else {
        paidLeaveInfo.style.display = 'none';
        leaveTypeInfo.innerHTML += '<br><span style="color: #ef4444; font-size: 11px;">Please select an employee first to see balance</span>';
      }
    } else {
      leaveTypeInfo.innerHTML = '<i class="fa fa-info-circle" style="color: #6b7280;"></i> This is an <strong>Unpaid Leave</strong> - No limit';
      leaveTypeInfo.style.color = '#6b7280';
      paidLeaveInfo.style.display = 'none';
    }
  } else {
    leaveTypeInfo.innerHTML = '';
    paidLeaveInfo.style.display = 'none';
  }
}

function fetchPaidLeaveBalance(employeeId) {
  const paidLeaveCount = document.getElementById('paid_leave_count');
  paidLeaveCount.textContent = 'Loading...';
  
  fetch(`/api/employee/${employeeId}/paid-leave-balance`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const used = data.yearly_used || 0;
        const total = 12;
        const monthUsed = data.month_used || 0;
        const monthAvailable = 1 - monthUsed;
        
        paidLeaveCount.innerHTML = `
          <div style="margin-bottom: 4px;">Yearly: <strong>${used}/12</strong> used</div>
          <div>This Month: <strong>${monthUsed}/1</strong> used 
            ${monthAvailable > 0 ? '<span style="color: #10b981;">(' + monthAvailable + ' available)</span>' : '<span style="color: #ef4444;">(Limit reached)</span>'}
          </div>
        `;
        
        // Disable paid leave if monthly limit reached
        if (monthAvailable <= 0) {
          document.getElementById('add_leave_category').value = '';
          document.getElementById('add_leave_type').innerHTML = '<option value="">Select Leave Type</option>';
          document.getElementById('paid_leave_info').style.display = 'none';
          alert('Monthly paid leave limit reached for this employee. Only 1 paid leave per month is allowed.');
        }
      } else {
        paidLeaveCount.textContent = 'Error loading balance';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      paidLeaveCount.textContent = 'Error loading balance';
    });
}

function submitLeave(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  
  // Convert dates from dd/mm/yyyy to yyyy-mm-dd format
  const startDate = formData.get('start_date');
  const endDate = formData.get('end_date');
  
  if (startDate && startDate.includes('/')) {
    const parts = startDate.split('/');
    formData.set('start_date', `${parts[2]}-${parts[1]}-${parts[0]}`);
  }
  
  if (endDate && endDate.includes('/')) {
    const parts = endDate.split('/');
    formData.set('end_date', `${parts[2]}-${parts[1]}-${parts[0]}`);
  }
  
  // Automatically set is_paid based on leave_type
  const leaveType = formData.get('leave_type');
  const paidTypes = ['casual', 'medical', 'company_holiday'];
  const isPaid = paidTypes.includes(leaveType) ? '1' : '0';
  formData.append('is_paid', isPaid);
  
  // Ensure total_days is sent as decimal
  const totalDays = parseFloat(formData.get('total_days'));
  formData.set('total_days', totalDays);
  
  fetch('{{ route("leave-approval.store") }}', {
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
        toastr.success(data.message || 'Leave request submitted successfully!');
      } else {
        alert(data.message || 'Leave request submitted successfully!');
      }
      closeAddLeaveModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      if (typeof toastr !== 'undefined') {
        toastr.error(data.message || 'Error submitting leave request');
      } else {
        alert(data.message || 'Error submitting leave request');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error submitting leave request');
    } else {
      alert('Error submitting leave request');
    }
  });
}

function approveLeave(id) {
  if (confirm('Are you sure you want to approve this leave request?')) {
    updateLeaveStatus(id, 'approved');
  }
}

function rejectLeave(id) {
  if (confirm('Are you sure you want to reject this leave request?')) {
    updateLeaveStatus(id, 'rejected');
  }
}

function updateLeaveStatus(id, status) {
  const formData = new FormData();
  formData.append('_method', 'PUT');
  formData.append('status', status);
  
  fetch(`{{ url('leave-approval') }}/${id}`, {
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
        toastr.success(data.message);
      } else {
        alert(data.message);
      }
      setTimeout(() => location.reload(), 1000);
    } else {
      if (typeof toastr !== 'undefined') {
        toastr.error(data.message || 'Error updating leave status');
      } else {
        alert(data.message || 'Error updating leave status');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error updating leave status');
    } else {
      alert('Error updating leave status');
    }
  });
}

function editLeave(id) {
  // Fetch leave data
  fetch(`{{ url('leave-approval') }}/${id}/edit`, {
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
      const leave = data.leave;
      
      // Populate edit modal
      document.getElementById('edit_leave_id').value = leave.id;
      document.getElementById('edit_employee_id').value = leave.employee_id;
      document.getElementById('edit_leave_type').value = leave.leave_type;
      document.getElementById('edit_start_date').value = leave.start_date;
      document.getElementById('edit_end_date').value = leave.end_date;
      document.getElementById('edit_total_days').value = leave.total_days;
      document.getElementById('edit_reason').value = leave.reason;
      document.getElementById('edit_status').value = leave.status;
      
      // Show edit modal
      document.getElementById('editLeaveModal').style.display = 'flex';
      
      // Calculate days for edit modal
      calculateEditModalDays();
    } else {
      if (typeof toastr !== 'undefined') {
        toastr.error(data.message || 'Error loading leave data');
      } else {
        alert(data.message || 'Error loading leave data');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error loading leave data');
    } else {
      alert('Error loading leave data');
    }
  });
}

function deleteLeave(id) {
  if (confirm('Are you sure you want to delete this leave request? This action cannot be undone.')) {
    const formData = new FormData();
    formData.append('_method', 'DELETE');
    
    fetch(`{{ url('leave-approval') }}/${id}`, {
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
          toastr.success('Leave request deleted successfully!');
        } else {
          alert('Leave request deleted successfully!');
        }
        setTimeout(() => location.reload(), 1000);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      if (typeof toastr !== 'undefined') {
        toastr.error('Error deleting leave request');
      } else {
        alert('Error deleting leave request');
      }
    });
  }
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

// Convert dates before form submission
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.jv-filter, #filterForm');
    if(form){
        form.addEventListener('submit', function(e){
            var dateInputs = form.querySelectorAll('.date-picker');
            dateInputs.forEach(function(input){
                if(input.value){
                    var parts = input.value.split('/');
                    if(parts.length === 3) input.value = parts[2] + '-' + parts[1] + '-' + parts[0];
                }
            });
        });
    }
});
</script>
@endpush

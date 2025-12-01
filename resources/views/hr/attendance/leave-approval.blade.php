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
      @foreach(\App\Models\Employee::orderBy('name')->get() as $emp)
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
      <button type="button" class="pill-btn pill-success" onclick="openAddLeaveModal()" style="display: flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
          <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
        Add Leave
      </button>
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
                <img src="{{ asset('action_icon/approve.svg') }}" alt="Approve" style="cursor: pointer; width: 20px; height: 20px;" onclick="approveLeave({{ $leave->id }})">
                <img src="{{ asset('action_icon/reject.svg') }}" alt="Reject" style="cursor: pointer; width: 20px; height: 20px;" onclick="rejectLeave({{ $leave->id }})">
              @else
                <!-- Edit/Delete buttons for approved/rejected leaves -->
                <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" style="cursor: pointer; width: 18px; height: 18px;" onclick="editLeave({{ $leave->id }})">
                <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" style="cursor: pointer; width: 18px; height: 18px;" onclick="deleteLeave({{ $leave->id }})">
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
        <tr>
          <td colspan="9" style="text-align: center; padding: 40px; color: #9ca3af;">
            <p style="font-weight: 600; margin: 0;">No leave requests found</p>
          </td>
        </tr>
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

<!-- Add Leave Modal -->
<div id="addLeaveModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h3 style="margin: 0 0 20px 0; font-size: 22px; font-weight: 700;">Add Leave Request</h3>
    
    <form id="addLeaveForm" onsubmit="submitLeave(event)">
      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Employee</label>
        <select name="employee_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          <option value="">Select Employee</option>
          @foreach(\App\Models\Employee::orderBy('name')->get() as $emp)
            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Leave Category</label>
        <select name="is_paid" id="add_leave_category" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" onchange="updateLeaveTypes()">
          <option value="">Select Category</option>
          <option value="1">Paid Leave</option>
          <option value="0">Unpaid Leave</option>
        </select>
        <div id="paid_leave_info" style="display: none; margin-top: 8px; padding: 8px; background: #f0f9ff; border-radius: 6px; font-size: 12px; color: #0c4a6e;">
          <strong>Paid Leave Balance:</strong> <span id="paid_leave_count">-</span>
        </div>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Leave Type</label>
        <select name="leave_type" id="add_leave_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
          <option value="">Select Leave Type</option>
        </select>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Start Date</label>
          <input type="date" name="start_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
        </div>
        <div>
          <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">End Date</label>
          <input type="date" name="end_date" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
        </div>
      </div>

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Total Days</label>
        <input type="number" name="total_days" step="0.1" min="0.1" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;" placeholder="Enter days (e.g., 1, 1.5, 0.5)">
        <small style="color: #6b7280; font-size: 12px;">Enter 0.5 for half day, 1 for full day, 1.5 for one and half days, etc.</small>
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
}

function updateLeaveTypes() {
  const category = document.getElementById('add_leave_category').value;
  const leaveType = document.getElementById('add_leave_type');
  const paidLeaveInfo = document.getElementById('paid_leave_info');
  const employeeId = document.querySelector('select[name="employee_id"]').value;
  
  leaveType.innerHTML = '<option value="">Select Leave Type</option>';
  
  if (category === '1') {
    leaveType.innerHTML += '<option value="casual">Casual Leave</option>';
    leaveType.innerHTML += '<option value="medical">Medical Leave</option>';
    
    // Show paid leave info and fetch balance
    if (employeeId) {
      paidLeaveInfo.style.display = 'block';
      fetchPaidLeaveBalance(employeeId);
    } else {
      paidLeaveInfo.style.display = 'none';
    }
  } else if (category === '0') {
    leaveType.innerHTML += '<option value="personal">Personal Leave</option>';
    leaveType.innerHTML += '<option value="company_holiday">Company Holiday</option>';
    paidLeaveInfo.style.display = 'none';
  } else {
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
  alert('Edit functionality coming soon');
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

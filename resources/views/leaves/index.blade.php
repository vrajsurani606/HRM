@extends('layouts.macos')
@section('page_title', 'My Leaves')

@section('content')
<div style="padding: 30px; max-width: 1400px; margin: 0 auto; background: #f8fafc; min-height: 100vh;">
  <!-- Header -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
      <h1 style="margin: 0 0 8px 0; font-size: 32px; font-weight: 800; color: #0f172a;">My Leaves</h1>
      <p style="margin: 0; color: #64748b; font-size: 15px;">Manage your leave requests</p>
    </div>
    <button onclick="openCreateModal()" style="padding: 12px 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
      <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
      </svg>
      Create Leave Request
    </button>
  </div>

  <!-- Leave Requests Table -->
  <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
          <th style="padding: 16px; text-align: left; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Type</th>
          <th style="padding: 16px; text-align: left; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Category</th>
          <th style="padding: 16px; text-align: left; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Dates</th>
          <th style="padding: 16px; text-align: center; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Days</th>
          <th style="padding: 16px; text-align: left; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Description</th>
          <th style="padding: 16px; text-align: center; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Status</th>
          <th style="padding: 16px; text-align: left; font-weight: 700; color: #0f172a; font-size: 13px; text-transform: uppercase;">Applied</th>
        </tr>
      </thead>
      <tbody>
        @forelse($leaves as $leave)
        <tr style="border-bottom: 1px solid #e2e8f0;">
          <td style="padding: 16px;">
            <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;
              @if($leave->leave_type == 'casual') background: #dbeafe; color: #0c4a6e;
              @elseif($leave->leave_type == 'medical') background: #fee2e2; color: #991b1b;
              @elseif($leave->leave_type == 'personal') background: #fef3c7; color: #92400e;
              @else background: #fbbf24; color: #78350f;
              @endif
            ">{{ ucfirst($leave->leave_type) }}</span>
          </td>
          <td style="padding: 16px;">
            <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;
              @if($leave->is_paid) background: #d1fae5; color: #065f46;
              @else background: #f3f4f6; color: #374151;
              @endif
            ">{{ $leave->is_paid ? 'Paid' : 'Unpaid' }}</span>
          </td>
          <td style="padding: 16px; color: #0f172a; font-size: 14px;">
            {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}
          </td>
          <td style="padding: 16px; text-align: center;">
            <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 600; color: #0f172a; font-size: 13px;">{{ $leave->total_days }}</span>
          </td>
          <td style="padding: 16px; color: #64748b; font-size: 13px;">{{ $leave->reason ?? '-' }}</td>
          <td style="padding: 16px; text-align: center;">
            @php
              $statusColor = match($leave->status) {
                'approved' => '#10b981',
                'rejected' => '#ef4444',
                'pending' => '#f59e0b',
                default => '#6b7280',
              };
            @endphp
            <span style="color: {{ $statusColor }}; font-weight: 700; font-size: 13px;">{{ ucfirst($leave->status) }}</span>
          </td>
          <td style="padding: 16px; color: #64748b; font-size: 13px;">{{ $leave->created_at->format('d M, Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8;">
            <div style="font-size: 16px; font-weight: 600;">No leave requests found</div>
            <p style="margin: 8px 0 0 0; font-size: 14px;">Click "Create Leave Request" to add your first leave</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($leaves->hasPages())
  <div style="margin-top: 20px;">
    {{ $leaves->links() }}
  </div>
  @endif
</div>

<!-- Create Leave Modal -->
<div id="createModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
  <div style="background: white; border-radius: 16px; padding: 40px; max-width: 600px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto;">
    <h2 style="margin: 0 0 30px 0; font-size: 26px; font-weight: 800; color: #0f172a;">Create Leave Request</h2>
    
    <form id="createForm" onsubmit="submitLeave(event)">
      @csrf
      
      <!-- Employee Selection (Admin/HR only) -->
      @if(auth()->user()->hasRole(['admin', 'hr']))
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">Employee *</label>
        <select name="employee_id" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; background: white;">
          <option value="">Select Employee</option>
          @foreach(\App\Models\Employee::orderBy('name')->get() as $emp)
            <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->code ?? 'N/A' }})</option>
          @endforeach
        </select>
      </div>
      @endif

      <!-- Leave Category -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">Leave Category *</label>
        <select name="is_paid" id="leave_category" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; background: white;" onchange="updateLeaveTypes()">
          <option value="">Select Category</option>
          <option value="1">Paid Leave</option>
          <option value="0">Unpaid Leave</option>
        </select>
      </div>

      <!-- Leave Type -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">Leave Type *</label>
        <select name="leave_type" id="leave_type" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; background: white;">
          <option value="">Select Leave Type</option>
        </select>
      </div>

      <!-- Date Range -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
        <div>
          <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">Start Date *</label>
          <input type="date" name="start_date" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
        </div>
        <div>
          <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">End Date *</label>
          <input type="date" name="end_date" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
        </div>
      </div>

      <!-- Total Days -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">Total Days *</label>
        <input type="number" name="total_days" step="0.1" min="0.1" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;" placeholder="Enter days (e.g., 1, 1.5, 0.5)">
        <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">Enter 0.5 for half day, 1 for full day, 1.5 for one and half days, etc.</small>
      </div>

      <!-- Description -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 700; font-size: 14px; color: #0f172a;">Description *</label>
        <textarea name="reason" rows="3" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;" placeholder="Enter reason for leave..."></textarea>
      </div>

      <!-- Buttons -->
      <div style="display: flex; gap: 12px; justify-content: flex-end;">
        <button type="button" onclick="closeCreateModal()" style="padding: 12px 24px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #0f172a; font-size: 14px;">Cancel</button>
        <button type="submit" style="padding: 12px 24px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px;">Submit Request</button>
      </div>
    </form>
  </div>
</div>

<script>
function openCreateModal() {
  document.getElementById('createModal').style.display = 'flex';
}

function closeCreateModal() {
  document.getElementById('createModal').style.display = 'none';
  document.getElementById('createForm').reset();
}

function updateLeaveTypes() {
  const category = document.getElementById('leave_category').value;
  const leaveType = document.getElementById('leave_type');
  
  leaveType.innerHTML = '<option value="">Select Leave Type</option>';
  
  if (category === '1') {
    // Paid leaves
    leaveType.innerHTML += '<option value="casual">Casual Leave</option>';
    leaveType.innerHTML += '<option value="medical">Medical Leave</option>';
  } else if (category === '0') {
    // Unpaid leaves
    leaveType.innerHTML += '<option value="personal">Personal Leave</option>';
    leaveType.innerHTML += '<option value="company_holiday">Company Holiday</option>';
  }
}

function submitLeave(event) {
  event.preventDefault();
  const formData = new FormData(event.target);
  
  fetch('{{ route("leaves.store") }}', {
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
        toastr.success(data.message || 'Leave request submitted successfully!');
      }
      closeCreateModal();
      setTimeout(() => location.reload(), 1000);
    } else {
      if (typeof toastr !== 'undefined') {
        toastr.error(data.message || 'Error submitting leave request');
      } else {
        toastr.error(data.message || 'Error submitting leave request');
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof toastr !== 'undefined') {
      toastr.error('Error submitting leave request');
    } else {
      toastr.error('Error submitting leave request');
    }
  });
}
</script>
@endsection




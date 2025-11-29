@extends('layouts.macos')
@section('page_title', 'Follow Up')

@section('content')
<div class="Rectangle-30 hrp-compact" style="margin-bottom: 16px;">
  <!-- Inquiry Details (readonly, styled like create/edit) -->
  <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    <div>
      <label class="hrp-label">Unique Code:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->unique_code }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Inquiry Date:</label>
      <input
        class="hrp-input Rectangle-29"
        value="{{ optional($inquiry->inquiry_date)->format('d-m-Y') }}"
        readonly
      />
    </div>

    <div>
      <label class="hrp-label">Company Name:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->company_name }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Company Address:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="height:58px;resize:none;" readonly>{{ $inquiry->company_address }}</textarea>
    </div>

    <div>
      <label class="hrp-label">Industry Type:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->industry_type }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Email:</label>
      <input class="hrp-input Rectangle-29" type="email" value="{{ $inquiry->email }}" readonly />
    </div>

    <div>
      <label class="hrp-label">Company Mo. No.:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->company_phone }}" readonly />
    </div>
    <div>
      <label class="hrp-label">City:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->city }}" readonly />
    </div>

    <div>
      <label class="hrp-label">State:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->state }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Contact Person Mobile No:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->contact_mobile }}" readonly />
    </div>

    <div>
      <label class="hrp-label">Contact Person Name:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->contact_name }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Scope Link:</label>
      <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;">
        @if($inquiry->scope_link)
          <a href="{{ $inquiry->scope_link }}" target="_blank" class="scope-link">{{ $inquiry->scope_link }}</a>
        @else
          <span>—</span>
        @endif
      </div>
    </div>

    <div>
      <label class="hrp-label">Contact Person Position:</label>
      <input class="hrp-input Rectangle-29" value="{{ $inquiry->contact_position }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Quotation Upload:</label>
      <div class="upload-pill Rectangle-29" style="opacity:0.7;cursor:default;">
        <div class="choose">Quotation File</div>
        <div class="filename">
          @if($inquiry->quotation_file)
            <a href="{{ url('public/storage/'.$inquiry->quotation_file) }}" target="_blank" class="scope-link">View File</a>
          @else
            No File Uploaded
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div class="Rectangle-30 hrp-compact" style="margin-bottom: 16px;">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">Previous Followup List</h3>
  <div style="font-size:12px;color:#4b5563;margin-bottom:8px;display:flex;flex-wrap:wrap;gap:16px;">
    <div><strong>Action:</strong> <span style="background:#2196f3;color:#ffffff;border-radius:999px;padding:2px 10px;font-size:11px;">MAKE CONFIRM</span> = pending, click to confirm.</div>
    <div><strong>Is Confirm:</strong> <span style="color:#16a34a;font-weight:600;">Confirmed</span>, <span style="color:#dc2626;font-weight:600;">No</span></div>
    <div><strong>Demo Status:</strong> <span style="color:#2563eb;font-weight:600;">Scheduled</span>, <span style="color:#16a34a;font-weight:600;">Done</span>, <span style="color:#dc2626;font-weight:600;">No</span></div>
  </div>
  <div style="max-height: 260px; overflow-y: auto; overflow-x: hidden; border-radius: 8px; border: 1px solid #e5e7eb;">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none followup-table" style="margin:0; border-radius:0;">
      <table>
      <thead>
        <tr>
          <th>Serial No.</th>
          <th>Action</th>
          <th>Is Confirm</th>
          <th>Remark</th>
          <th>Followup Date</th>
          <th>Next Date</th>
          <th>Demo Status</th>
          <th>Scheduled Demo Date</th>
          <th>Scheduled Demo Time</th>
          <th></th>Demo Date &amp; Time</th>
          <th>Code</th>
        </tr>
      </thead>
      <tbody>
        @forelse($followUps as $index => $followUp)
        <tr data-followup-id="{{ $followUp->id }}" @if($followUp->is_confirm) style="background:#ecfdf3;" @endif>
          <td>{{ $index + 1 }}</td>
          <td>
            @if($followUp->is_confirm)
              <span class="text-green-600" style="color:#16a34a;font-weight:600;">Confirmed</span>
            @else
              <button type="button" class="make-confirm-btn" style="background:#2196f3;color:#ffffff;border:none;border-radius:999px;padding:4px 16px;font-size:12px;font-weight:600;cursor:pointer;">MAKE CONFIRM</button>
            @endif
          </td>
          <td>
            @if($followUp->is_confirm)
              <span class="text-green-600" style="color:#16a34a;font-weight:600;">Confirmed</span>
            @else
              <span style="color:#dc2626;font-weight:600;">No</span>
            @endif
          </td>
          <td>{{ $followUp->remark }}</td>
          <td>{{ optional($followUp->followup_date)->format('d-m-Y') }}</td>
          <td>{{ optional($followUp->next_followup_date)->format('d-m-Y') }}</td>
          <td>
            @php
              $status = strtolower((string) $followUp->demo_status);
            @endphp
            @if($status === 'schedule')
              <span style="color:#2563eb;font-weight:600;">Scheduled</span>
            @elseif($status === 'yes')
              <span style="color:#16a34a;font-weight:600;">Done</span>
            @elseif($status === 'no')
              <span style="color:#dc2626;font-weight:600;">No</span>
            @else
              <span>{{ ucfirst($followUp->demo_status) }}</span>
            @endif
          </td>
          <td>{{ optional($followUp->scheduled_demo_date)->format('d-m-Y') }}</td>
          <td>{{ $followUp->scheduled_demo_time }}</td>
          <td>
            @if($followUp->demo_date || $followUp->demo_time)
              {{ optional($followUp->demo_date)->format('d-m-Y') }} {{ $followUp->demo_time }}
            @else
              {{ optional($followUp->created_at)->format('d-m-Y H:i') }}
            @endif
          </td>
          <td>{{ $inquiry->unique_code }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="9" style="text-align:center;">No follow-ups found</td>
        </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
</div>

<div class="Rectangle-30 hrp-compact">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">Add Followup</h3>
  <form method="POST" action="{{ route('inquiry.follow-up.store', $inquiry->id) }}" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    @csrf

    <div>
      <label class="hrp-label">Code:</label>
      <input class="hrp-input Rectangle-29" name="code" value="{{ $inquiry->unique_code }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Follow Up Date:</label>
      <input
        type="text"
        class="hrp-input Rectangle-29"
        name="followup_date"
        value="{{ optional($inquiry->inquiry_date)->format('d/m/y') }}"
        readonly
      />
      @error('followup_date')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Next Follow Up Date:</label>
      <input type="date" class="hrp-input Rectangle-29" name="next_followup_date" value="{{ old('next_followup_date') }}" />
      @error('next_followup_date')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Demo Status:</label>
      <select class="Rectangle-29 Rectangle-29-select" name="demo_status" id="demo_status">
        <option value="">Select Status</option>
        <option value="schedule" {{ old('demo_status') === 'schedule' ? 'selected' : '' }}>Schedule Demo</option>
        <option value="yes" {{ old('demo_status') === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ old('demo_status') === 'no' ? 'selected' : '' }}>No</option>
      </select>
      @error('demo_status')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <div id="demo-schedule-fields" class="md:col-span-2" style="display:none;">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Scheduled Demo Date:</label>
          <input type="date" class="hrp-input Rectangle-29" name="scheduled_demo_date" value="{{ old('scheduled_demo_date') }}" />
          @error('scheduled_demo_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Scheduled Demo Time:</label>
          <input type="time" class="hrp-input Rectangle-29" name="scheduled_demo_time" value="{{ old('scheduled_demo_time') }}" />
          @error('scheduled_demo_time')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>
    </div>

    <div id="demo-done-fields" class="md:col-span-2" style="display:none;">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Demo Date:</label>
          <input type="date" class="hrp-input Rectangle-29" name="demo_date" value="{{ old('demo_date') }}" />
          @error('demo_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Demo Time:</label>
          <input type="time" class="hrp-input Rectangle-29" name="demo_time" value="{{ old('demo_time') }}" />
          @error('demo_time')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>
    </div>

    <div>
      <label class="hrp-label">Remark:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="remark" placeholder="Enter Remark" style="height:80px;resize:vertical;">{{ old('remark') }}</textarea>
      @error('remark')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Inquiry:</label>
      <select class="Rectangle-29 Rectangle-29-select" name="inquiry_note">
        <option value="">Select Inquiry</option>
        <option value="{{ $inquiry->company_name }}" {{ old('inquiry_note') == $inquiry->company_name ? 'selected' : '' }}>
          {{ $inquiry->company_name }}
        </option>
      </select>
      @error('inquiry_note')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <div class="md:col-span-2">
      <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:30px;">
        <a href="{{ route('inquiries.index') }}" class="hrp-btn" style="background:#e5e7eb;color:#111827;">Cancel</a>
        <button type="submit" class="hrp-btn hrp-btn-primary">Add Follow Up</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('inquiries.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiry Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Follow Up</span>
@endsection

@push('styles')
<style>
  .JV-datatble.followup-table td:first-child {
    display: table-cell !important;
    align-items: initial;
    gap: 0;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var statusSelect = document.getElementById('demo_status');
    var scheduleFields = document.getElementById('demo-schedule-fields');
    var doneFields = document.getElementById('demo-done-fields');

    if (!statusSelect || !scheduleFields || !doneFields) return;

    function updateDemoFields() {
      var value = statusSelect.value;
      if (value === 'schedule') {
        scheduleFields.style.display = 'block';
        doneFields.style.display = 'none';
      } else if (value === 'yes') {
        scheduleFields.style.display = 'none';
        doneFields.style.display = 'block';
      } else {
        scheduleFields.style.display = 'none';
        doneFields.style.display = 'none';
      }
    }

    statusSelect.addEventListener('change', updateDemoFields);
    updateDemoFields();

    // MAKE CONFIRM actions
    var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    document.querySelectorAll('.make-confirm-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var row = this.closest('tr');
        var followUpId = row.getAttribute('data-followup-id');
        if (!followUpId) return;

        Swal.fire({
          title: 'Are you sure to confirm?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#16a34a',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          width: '380px',
        }).then(function (result) {
          if (!result.isConfirmed) return;

          fetch("{{ route('inquiry.follow-up.confirm', ['followUp' => 'FOLLOWUP_ID']) }}".replace('FOLLOWUP_ID', followUpId), {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json',
            },
          })
          .then(function (res) { return res.json(); })
          .then(function (data) {
            if (data && data.success) {
              // Update Action and Is Confirm cells
              var cells = row.querySelectorAll('td');
              // cells: [Serial, Action, Is Confirm, Remark, ...]
              if (cells[1]) {
                cells[1].innerHTML = '<span style="color:#16a34a;font-weight:600;">Confirmed</span>';
              }
              if (cells[2]) {
                cells[2].innerHTML = '<span style="color:#16a34a;font-weight:600;">Confirmed</span>';
              }

              Swal.fire({
                title: 'Follow Up Confirm Successfully',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                width: '380px',
              });
            }
          })
          .catch(function () {
            Swal.fire('Error', 'Unable to confirm follow-up.', 'error');
          });
        });
      });
    });
  });
</script>
@endpush
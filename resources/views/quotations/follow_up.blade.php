@extends('layouts.macos')
@section('page_title', 'Quotation Follow Up')

@section('content')
<div class="Rectangle-30 hrp-compact" style="margin-bottom: 16px;">
  <!-- Quotation Details (readonly) -->
  <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    <div>
      <label class="hrp-label">Quotation Code:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->unique_code }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Quotation Date:</label>
      <input
        class="hrp-input Rectangle-29"
        value="{{ optional($quotation->quotation_date)->format('d-m-Y') }}"
        readonly
      />
    </div>

    <div>
      <label class="hrp-label">Company Name:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->company_name }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Quotation Title:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->quotation_title }}" readonly />
    </div>

    <div>
      <label class="hrp-label">Contact Person:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->contact_person_1 }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Contact Number:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->contact_number_1 }}" readonly />
    </div>

    <div>
      <label class="hrp-label">Email:</label>
      <input class="hrp-input Rectangle-29" type="email" value="{{ $quotation->company_email }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Contract Amount:</label>
      <input class="hrp-input Rectangle-29" value="₹ {{ number_format($quotation->service_contract_amount, 2) }}" readonly />
    </div>

    <div>
      <label class="hrp-label">City:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->city }}" readonly />
    </div>
    <div>
      <label class="hrp-label">State:</label>
      <input class="hrp-input Rectangle-29" value="{{ $quotation->state }}" readonly />
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Address:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="height:58px;resize:none;" readonly>{{ $quotation->address }}</textarea>
    </div>
  </div>
</div>

<div class="Rectangle-30 hrp-compact" style="margin-bottom: 16px;">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">Previous Followup List</h3>
  <div style="font-size:12px;color:#4b5563;margin-bottom:8px;display:flex;flex-wrap:wrap;gap:16px;">
    <div><strong>Action:</strong> <span style="background:#2196f3;color:#ffffff;border-radius:999px;padding:2px 10px;font-size:11px;">MAKE CONFIRM</span> = pending, click to confirm.</div>
    <div><strong>Is Confirm:</strong> <span style="color:#16a34a;font-weight:600;">Confirmed</span>, <span style="color:#dc2626;font-weight:600;">No</span></div>
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
          <td>{{ $quotation->unique_code }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;">No follow-ups found</td>
        </tr>
        @endforelse
      </tbody>
      </table>
    </div>
  </div>
</div>

<div class="Rectangle-30 hrp-compact">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">Add Followup</h3>
  <form method="POST" action="{{ route('quotation.follow-up.store', $quotation->id) }}" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    @csrf

    <div>
      <label class="hrp-label">Code:</label>
      <input class="hrp-input Rectangle-29" name="code" value="{{ $quotation->unique_code }}" readonly />
    </div>
    <div>
      <label class="hrp-label">Follow Up Date:</label>
      <input
        type="text"
        class="hrp-input Rectangle-29"
        name="followup_date"
        value="{{ optional($quotation->quotation_date)->format('d/m/y') }}"
        readonly
      />
      @error('followup_date')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Next Follow Up Date:</label>
      <input type="date" class="hrp-input Rectangle-29" name="next_followup_date" value="{{ old('next_followup_date') }}" />
      @error('next_followup_date')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Remark:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="remark" placeholder="Enter Remark" style="height:80px;resize:vertical;">{{ old('remark') }}</textarea>
      @error('remark')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <div class="md:col-span-2">
      <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:30px;">
        <a href="{{ route('quotations.index') }}" class="hrp-btn" style="background:#e5e7eb;color:#111827;">Cancel</a>
        <button type="submit" class="hrp-btn hrp-btn-primary">Add Follow Up</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('quotations.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Quotation Management</a>
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

          fetch("{{ route('quotation.follow-up.confirm', ['followUp' => 'FOLLOWUP_ID']) }}".replace('FOLLOWUP_ID', followUpId), {
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

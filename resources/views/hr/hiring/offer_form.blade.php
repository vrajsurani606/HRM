@extends('layouts.macos')
@section('page_title', $page_title)

@push('styles')
<!-- jQuery UI CSS for Datepicker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('content')
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ $offer ? route('hiring.offer.update', $lead->id) : route('hiring.offer.store', $lead->id) }}" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="offerForm">
        @csrf
        @if($offer)
          @method('PUT')
        @endif

        <div class="md:col-span-2">
          <div class="hrp-alert hrp-alert-info" role="alert">
            <strong>Hiring Lead:</strong> {{ $lead->unique_code }} — {{ $lead->person_name }} ({{ $lead->position }})
          </div>
        </div>

        <div>
          <label class="hrp-label">Letter Issue Date:</label>
          <input type="text" name="issue_date" id="issue_date" value="{{ old('issue_date', optional($offer->issue_date ?? null)->format('d/m/Y')) }}" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          @error('issue_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Letter Note:</label>
          <input name="note" value="{{ old('note', $offer->note ?? '') }}" placeholder="Optional note" class="hrp-input Rectangle-29">
          @error('note')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Monthly Salary:</label>
          <input type="number" step="0.01" min="0" name="monthly_salary" id="hiring_monthly_salary" value="{{ old('monthly_salary', $offer->monthly_salary ?? '') }}" placeholder="e.g. 35000" class="hrp-input Rectangle-29">
          @error('monthly_salary')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Annual CTC:</label>
          <input type="number" step="0.01" min="0" name="annual_ctc" id="hiring_annual_ctc" value="{{ old('annual_ctc', $offer->annual_ctc ?? '') }}" placeholder="e.g. 420000" class="hrp-input Rectangle-29" readonly>
          <small class="text-xs text-gray-500">Auto-calculated (Monthly Salary × 12)</small>
          @error('annual_ctc')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Reporting Manager:</label>
          <input name="reporting_manager" value="{{ old('reporting_manager', $offer->reporting_manager ?? '') }}" placeholder="Manager name" class="hrp-input Rectangle-29">
          @error('reporting_manager')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Working Time:</label>
          <input name="working_hours" value="{{ old('working_hours', $offer->working_hours ?? '') }}" placeholder="e.g. 9:30 AM - 6:30 PM" class="hrp-input Rectangle-29">
          @error('working_hours')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Date of Joining:</label>
          <input type="text" name="date_of_joining" id="date_of_joining" value="{{ old('date_of_joining', optional($offer->date_of_joining ?? null)->format('d/m/Y')) }}" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          @error('date_of_joining')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-2">
          <label class="hrp-label">Probation Period (bulleted lines):</label>
          <textarea name="probation_period" rows="4" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter each point on new line">{{ old('probation_period', $offer->probation_period ?? '') }}</textarea>
          @error('probation_period')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-2">
          <label class="hrp-label">Salary & Increment (bulleted lines):</label>
          <textarea name="salary_increment" rows="4" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter each point on new line">{{ old('salary_increment', $offer->salary_increment ?? '') }}</textarea>
          @error('salary_increment')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button class="hrp-btn hrp-btn-primary" name="save" value="1">{{ $offer ? 'Update Offer Letter' : 'Save Offer Letter' }}</button>
            <button class="hrp-btn" name="save_and_print" value="1">Save & Print</button>
            <a class="hrp-btn hrp-btn-ghost" href="{{ route('hiring.index') }}">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('hiring.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">{{ $page_title }}</span>
@endsection

@push('scripts')
<!-- jQuery UI JS for Datepicker -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize jQuery datepicker
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+10',
        showButtonPanel: true
    });
    
    // Set today's date as default for issue date if empty
    const issueDateEl = document.getElementById('issue_date');
    if (issueDateEl && !issueDateEl.value) {
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const yyyy = today.getFullYear();
        issueDateEl.value = dd + '/' + mm + '/' + yyyy;
    }
    
    // Set default joining date to 7 days from now if empty
    const joiningEl = document.getElementById('date_of_joining');
    if (joiningEl && !joiningEl.value) {
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 7);
        const dd2 = String(nextWeek.getDate()).padStart(2, '0');
        const mm2 = String(nextWeek.getMonth() + 1).padStart(2, '0');
        const yyyy2 = nextWeek.getFullYear();
        joiningEl.value = dd2 + '/' + mm2 + '/' + yyyy2;
    }
});

// Auto-calculate Annual CTC from Monthly Salary
$(document).on('input', '#hiring_monthly_salary', function() {
    var monthlySalary = parseFloat($(this).val()) || 0;
    var annualCTC = monthlySalary * 12;
    $('#hiring_annual_ctc').val(annualCTC.toFixed(2));
});

// Trigger calculation on page load if value exists
if ($('#hiring_monthly_salary').val()) {
    $('#hiring_monthly_salary').trigger('input');
}

// Convert dates from dd/mm/yyyy to yyyy-mm-dd before form submission
$('#offerForm').on('submit', function(e) {
    $('.date-picker').each(function() {
        const dateValue = $(this).val();
        if (dateValue && dateValue.match(/^\d{1,2}\/\d{1,2}\/\d{2,4}$/)) {
            const parts = dateValue.split('/');
            const day = parts[0].padStart(2, '0');
            const month = parts[1].padStart(2, '0');
            let year = parts[2];
            
            // Convert 2-digit year to 4-digit if needed
            if (year.length === 2) {
                const currentYear = new Date().getFullYear();
                const century = Math.floor(currentYear / 100) * 100;
                year = century + parseInt(year);
            }
            
            // Create hidden input with converted date
            const hiddenInput = $('<input>')
                .attr('type', 'hidden')
                .attr('name', $(this).attr('name'))
                .val(year + '-' + month + '-' + day);
            
            // Remove name from original input and add hidden input
            $(this).removeAttr('name');
            $(this).after(hiddenInput);
        }
    });
});
</script>
@endpush

@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('attendance.store') }}" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="attendanceForm">
        @csrf
        
        <div>
          <label class="hrp-label">Employee: <span class="text-red-500">*</span></label>
          <select name="employee_id" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Employee</option>
            @foreach($employees as $employee)
              <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                {{ $employee->code }} - {{ $employee->name }}
              </option>
            @endforeach
          </select>
          @error('employee_id')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Date: <span class="text-red-500">*</span></label>
          <input name="date" value="{{ old('date', date('Y-m-d')) }}" class="hrp-input Rectangle-29" type="date" required>
          @error('date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Check In Time: <span class="text-red-500">*</span></label>
          <input name="check_in" value="{{ old('check_in', '09:30') }}" class="hrp-input Rectangle-29" type="time" required>
          @error('check_in')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Check Out Time:</label>
          <input name="check_out" value="{{ old('check_out', '18:30') }}" class="hrp-input Rectangle-29" type="time">
          <small class="text-gray-500 text-xs">Leave empty if employee hasn't checked out yet</small>
          @error('check_out')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Status: <span class="text-red-500">*</span></label>
          <select name="status" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Status</option>
            <option value="present" {{ old('status') === 'present' ? 'selected' : '' }}>Present</option>
            <option value="absent" {{ old('status') === 'absent' ? 'selected' : '' }}>Absent</option>
            <option value="half_day" {{ old('status') === 'half_day' ? 'selected' : '' }}>Half Day</option>
            <option value="late" {{ old('status') === 'late' ? 'selected' : '' }}>Late</option>
            <option value="early_leave" {{ old('status') === 'early_leave' ? 'selected' : '' }}>Early Leave</option>
          </select>
          @error('status')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-2">
          <label class="hrp-label">Notes:</label>
          <textarea name="notes" placeholder="Add any notes or remarks (optional)" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" maxlength="500">{{ old('notes') }}</textarea>
          <small class="text-gray-500 text-xs">Maximum 500 characters</small>
          @error('notes')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button type="submit" class="hrp-btn hrp-btn-primary">Create Attendance Record</button>
            <a href="{{ route('attendance.reports') }}" class="hrp-btn hrp-btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
      </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('attendance.reports') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Attendance</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Attendance Record</span>
@endsection

@push('scripts')
<script>
(function(){
  var form = document.getElementById('attendanceForm');
  var checkInInput = document.querySelector('input[name="check_in"]');
  var checkOutInput = document.querySelector('input[name="check_out"]');
  var statusSelect = document.querySelector('select[name="status"]');

  // Auto-suggest status based on times
  function suggestStatus() {
    if (!checkInInput.value) return;
    
    var checkIn = checkInInput.value.split(':');
    var checkInHour = parseInt(checkIn[0]);
    var checkInMinute = parseInt(checkIn[1]);
    
    // Late if after 9:45 AM
    if (checkInHour > 9 || (checkInHour === 9 && checkInMinute > 45)) {
      if (!statusSelect.value || statusSelect.value === 'present') {
        statusSelect.value = 'late';
      }
    }
    
    // Check early leave if check out time is provided
    if (checkOutInput.value) {
      var checkOut = checkOutInput.value.split(':');
      var checkOutHour = parseInt(checkOut[0]);
      
      // Calculate working hours
      var totalMinutes = (checkOutHour * 60 + parseInt(checkOut[1])) - (checkInHour * 60 + checkInMinute);
      var hours = totalMinutes / 60;
      
      // Half day if less than 4 hours
      if (hours < 4) {
        statusSelect.value = 'half_day';
      }
      // Early leave if before 6:00 PM
      else if (checkOutHour < 18) {
        if (statusSelect.value !== 'late') {
          statusSelect.value = 'early_leave';
        }
      }
      // Present if 6+ hours and not late
      else if (hours >= 6 && statusSelect.value !== 'late') {
        statusSelect.value = 'present';
      }
    }
  }

  if (checkInInput) {
    checkInInput.addEventListener('change', suggestStatus);
  }
  
  if (checkOutInput) {
    checkOutInput.addEventListener('change', suggestStatus);
  }

  if(form){
    form.addEventListener('submit', function(e){
      if(!form.checkValidity()){
        e.preventDefault();
        form.reportValidity();
      }
    });
  }
})();
</script>
@endpush

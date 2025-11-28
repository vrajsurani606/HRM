@extends('layouts.macos')
@section('page_title', 'Request Leave')

@section('content')
<div class="hrp-container" style="padding: 24px; max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <a href="{{ route('leaves.index') }}" class="hrp-btn hrp-btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Leaves
        </a>
    </div>

    <div class="hrp-card">
        <div class="hrp-card-header">
            <h2 style="margin: 0; font-size: 22px; font-weight: 700;">Request Leave</h2>
        </div>
        <div class="hrp-card-body">
            <!-- Leave Balance Summary -->
            <div style="background: #f9fafb; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #374151;">Your Leave Balance</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div>
                        <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Paid Leave (Casual + Medical)</div>
                        <div style="font-size: 24px; font-weight: 700; color: #667eea;">
                            {{ number_format($leaveBalance->paid_leave_balance, 1) }} days
                        </div>
                        <div style="font-size: 11px; color: #9ca3af; margin-top: 4px;">
                            Used: {{ number_format($leaveBalance->paid_leave_used, 1) }} / {{ number_format($leaveBalance->paid_leave_total, 1) }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Breakdown</div>
                        <div style="font-size: 13px; color: #374151; margin-top: 4px;">
                            <div>Casual: {{ number_format($leaveBalance->casual_leave_used, 1) }} days</div>
                            <div>Medical: {{ number_format($leaveBalance->medical_leave_used, 1) }} days</div>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Unpaid Leave</div>
                        <div style="font-size: 24px; font-weight: 700; color: #4facfe;">
                            Unlimited
                        </div>
                        <div style="font-size: 11px; color: #9ca3af; margin-top: 4px;">
                            Personal: {{ number_format($leaveBalance->personal_leave_used, 1) }} days<br>
                            Holiday: {{ number_format($leaveBalance->holiday_leave_used ?? 0, 1) }} days
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('leaves.store') }}" method="POST" id="leaveForm">
                @csrf

                <div class="hrp-form-group">
                    <label for="leave_type" class="hrp-label">Leave Type <span style="color: red;">*</span></label>
                    <select name="leave_type" id="leave_type" class="hrp-input" required>
                        <option value="">Select Leave Type</option>
                        @foreach($leaveTypes as $type => $details)
                        <option value="{{ $type }}" {{ old('leave_type') == $type ? 'selected' : '' }}>
                            {{ $details['name'] }} 
                            @if($details['is_paid'])
                                (Paid) - Balance: {{ number_format($leaveBalance->paid_leave_balance, 1) }} days
                            @else
                                (Unpaid) - No Limit
                            @endif
                        </option>
                        @endforeach
                    </select>
                    @error('leave_type')
                        <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="hrp-grid">
                    <div class="hrp-col-6">
                        <div class="hrp-form-group">
                            <label for="start_date" class="hrp-label">Start Date <span style="color: red;">*</span></label>
                            <input type="date" name="start_date" id="start_date" class="hrp-input" 
                                   value="{{ old('start_date') }}" min="{{ now()->format('Y-m-d') }}" required>
                            @error('start_date')
                                <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="hrp-col-6">
                        <div class="hrp-form-group">
                            <label for="end_date" class="hrp-label">End Date <span style="color: red;">*</span></label>
                            <input type="date" name="end_date" id="end_date" class="hrp-input" 
                                   value="{{ old('end_date') }}" min="{{ now()->format('Y-m-d') }}" required>
                            @error('end_date')
                                <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="hrp-form-group">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="is_half_day" id="is_half_day" value="1" 
                               {{ old('is_half_day') ? 'checked' : '' }} style="margin-right: 8px;">
                        <span>This is a half-day leave (0.5 days)</span>
                    </label>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Check this if you only need half day off. Start and end date should be the same.
                    </small>
                </div>

                <div class="hrp-form-group">
                    <label for="reason" class="hrp-label">Reason <span style="color: red;">*</span></label>
                    <textarea name="reason" id="reason" rows="4" class="hrp-input" 
                              placeholder="Please provide a reason for your leave request..." required>{{ old('reason') }}</textarea>
                    @error('reason')
                        <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span>
                    @enderror
                </div>

                <div id="calculatedDays" style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 8px; margin-bottom: 20px; display: none;">
                    <div style="font-size: 14px; color: #1e40af; font-weight: 600;">
                        <i class="fa fa-info-circle"></i> Calculated Leave Days: <span id="daysCount">0</span> day(s)
                    </div>
                    <div style="font-size: 12px; color: #3b82f6; margin-top: 4px;">
                        (Excluding weekends)
                    </div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('leaves.index') }}" class="hrp-btn hrp-btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="hrp-btn hrp-btn-primary">
                        <i class="fa fa-paper-plane"></i> Submit Leave Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const isHalfDay = document.getElementById('is_half_day');
    const calculatedDays = document.getElementById('calculatedDays');
    const daysCount = document.getElementById('daysCount');

    // Update end date min value when start date changes
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
        calculateDays();
    });

    endDate.addEventListener('change', calculateDays);
    isHalfDay.addEventListener('change', function() {
        if (this.checked && startDate.value) {
            endDate.value = startDate.value;
        }
        calculateDays();
    });

    function calculateDays() {
        if (!startDate.value || !endDate.value) {
            calculatedDays.style.display = 'none';
            return;
        }

        if (isHalfDay.checked) {
            daysCount.textContent = '0.5';
            calculatedDays.style.display = 'block';
            return;
        }

        // Simple calculation (actual calculation happens on server)
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        daysCount.textContent = diffDays;
        calculatedDays.style.display = 'block';
    }
});
</script>
@endsection
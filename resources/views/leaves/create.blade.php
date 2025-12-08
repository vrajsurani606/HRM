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
                        <option value="{{ $type }}" 
                                data-is-paid="{{ $details['is_paid'] ? '1' : '0' }}"
                                {{ old('leave_type') == $type ? 'selected' : '' }}>
                            {{ $details['name'] }} @if($details['is_paid'])(Paid)@else(Unpaid)@endif
                        </option>
                        @endforeach
                    </select>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 8px; display: block;">
                        <span id="leaveTypeInfo"></span>
                    </small>
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

                <div id="calculatedDays" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 20px; margin-bottom: 20px; display: none; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                    <div style="display: flex; align-items: center; justify-content: space-between; color: white;">
                        <div>
                            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 4px;">
                                <i class="fa fa-calendar"></i> Total Leave Days
                            </div>
                            <div style="font-size: 32px; font-weight: 800; line-height: 1;">
                                <span id="daysCount">0</span> <span style="font-size: 18px; font-weight: 600;">days</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 11px; opacity: 0.8; margin-bottom: 4px;">Calculation</div>
                            <div style="font-size: 13px; font-weight: 600;">
                                <i class="fa fa-check-circle"></i> Sundays Excluded
                            </div>
                        </div>
                    </div>
                    <div id="dateRangeDisplay" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.2); font-size: 12px; color: rgba(255,255,255,0.9);">
                        <i class="fa fa-arrow-right"></i> <span id="dateRangeText"></span>
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
    const leaveType = document.getElementById('leave_type');
    const leaveTypeInfo = document.getElementById('leaveTypeInfo');

    // Show leave type information
    leaveType.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const isPaid = selectedOption.getAttribute('data-is-paid') === '1';
        
        if (this.value) {
            if (isPaid) {
                leaveTypeInfo.innerHTML = '<i class="fa fa-check-circle" style="color: #10b981;"></i> This is a <strong>Paid Leave</strong>. Available balance: {{ number_format($leaveBalance->paid_leave_balance, 1) }} days';
                leaveTypeInfo.style.color = '#10b981';
            } else {
                leaveTypeInfo.innerHTML = '<i class="fa fa-info-circle" style="color: #6b7280;"></i> This is an <strong>Unpaid Leave</strong>. No limit on days.';
                leaveTypeInfo.style.color = '#6b7280';
            }
        } else {
            leaveTypeInfo.innerHTML = '';
        }
    });

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

        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        
        // Format dates for display
        const startFormatted = start.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const endFormatted = end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        
        if (isHalfDay.checked) {
            daysCount.textContent = '0.5';
            document.getElementById('dateRangeText').textContent = `${startFormatted} (Half Day)`;
            calculatedDays.style.display = 'block';
            return;
        }

        // Calculate business days (excluding weekends)
        let totalDays = 0;
        let weekendDays = 0;
        
        for (let date = new Date(start); date <= end; date.setDate(date.getDate() + 1)) {
            const dayOfWeek = date.getDay();
            // Skip only Sunday (0 = Sunday)
            if (dayOfWeek !== 0) {
                totalDays++;
            } else {
                weekendDays++;
            }
        }
        
        // Update display
        daysCount.textContent = totalDays;
        
        // Show date range with Sunday info
        let rangeText = `${startFormatted} → ${endFormatted}`;
        if (weekendDays > 0) {
            rangeText += ` (${weekendDays} Sunday${weekendDays > 1 ? 's' : ''} excluded)`;
        }
        document.getElementById('dateRangeText').textContent = rangeText;
        
        calculatedDays.style.display = 'block';
        
        // Add animation
        calculatedDays.style.animation = 'none';
        setTimeout(() => {
            calculatedDays.style.animation = 'slideIn 0.3s ease-out';
        }, 10);
    }
    
    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
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
});
</script>
@endsection
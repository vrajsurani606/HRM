@extends('layouts.macos')
@section('page_title', 'Leave Details')

@section('content')
<div class="hrp-container" style="padding: 24px; max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <a href="{{ route('leaves.index') }}" class="hrp-btn hrp-btn-secondary">
            <i class="fa fa-arrow-left"></i> Back to Leaves
        </a>
    </div>

    <div class="hrp-card">
        <div class="hrp-card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: 22px; font-weight: 700;">Leave Request Details</h2>
            <span class="badge {{ $leave->status_badge_class }}" style="font-size: 14px; padding: 8px 16px;">
                {{ ucfirst($leave->status) }}
            </span>
        </div>
        <div class="hrp-card-body">
            <div style="display: grid; gap: 24px;">
                <!-- Employee Info -->
                <div>
                    <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">Employee</h3>
                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #111;">
                        {{ $leave->employee->name ?? 'N/A' }}
                    </p>
                </div>

                <!-- Leave Type -->
                <div>
                    <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">Leave Type</h3>
                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #111;">
                        {{ $leave->leave_type_name }}
                        @if($leave->is_paid)
                            <span style="font-size: 13px; color: #10b981; margin-left: 8px;">(Paid)</span>
                        @else
                            <span style="font-size: 13px; color: #6b7280; margin-left: 8px;">(Unpaid)</span>
                        @endif
                    </p>
                </div>

                <!-- Duration -->
                <div class="hrp-grid">
                    <div class="hrp-col-4">
                        <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">Start Date</h3>
                        <p style="margin: 0; font-size: 16px; font-weight: 600; color: #111;">
                            {{ $leave->start_date->format('d M Y') }}
                        </p>
                    </div>
                    <div class="hrp-col-4">
                        <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">End Date</h3>
                        <p style="margin: 0; font-size: 16px; font-weight: 600; color: #111;">
                            {{ $leave->end_date->format('d M Y') }}
                        </p>
                    </div>
                    <div class="hrp-col-4">
                        <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">Total Days</h3>
                        <p style="margin: 0; font-size: 16px; font-weight: 600; color: #111;">
                            {{ number_format($leave->total_days, 1) }} day(s)
                            @if($leave->is_half_day)
                                <span style="font-size: 12px; color: #6b7280;">(Half Day)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Reason -->
                <div>
                    <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">Reason</h3>
                    <p style="margin: 0; font-size: 15px; color: #374151; line-height: 1.6;">
                        {{ $leave->reason }}
                    </p>
                </div>

                <!-- Approval/Rejection Info -->
                @if($leave->status === 'approved' && $leave->approver)
                <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 16px; border-radius: 8px;">
                    <h3 style="font-size: 14px; color: #065f46; margin: 0 0 8px 0; font-weight: 600;">
                        <i class="fa fa-check-circle"></i> Approved By
                    </h3>
                    <p style="margin: 0; font-size: 15px; color: #065f46;">
                        {{ $leave->approver->name }} on {{ $leave->approved_at->format('d M Y, h:i A') }}
                    </p>
                    @if($leave->remarks)
                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #065f46;">
                        <strong>Remarks:</strong> {{ $leave->remarks }}
                    </p>
                    @endif
                </div>
                @endif

                @if($leave->status === 'rejected' && $leave->rejecter)
                <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 16px; border-radius: 8px;">
                    <h3 style="font-size: 14px; color: #991b1b; margin: 0 0 8px 0; font-weight: 600;">
                        <i class="fa fa-times-circle"></i> Rejected By
                    </h3>
                    <p style="margin: 0; font-size: 15px; color: #991b1b;">
                        {{ $leave->rejecter->name }} on {{ $leave->rejected_at->format('d M Y, h:i A') }}
                    </p>
                    @if($leave->remarks)
                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #991b1b;">
                        <strong>Reason:</strong> {{ $leave->remarks }}
                    </p>
                    @endif
                </div>
                @endif

                <!-- Applied Date -->
                <div>
                    <h3 style="font-size: 14px; color: #6b7280; margin: 0 0 8px 0; font-weight: 600;">Applied On</h3>
                    <p style="margin: 0; font-size: 15px; color: #374151;">
                        {{ $leave->created_at->format('d M Y, h:i A') }}
                    </p>
                </div>

                <!-- Actions -->
                @php
                    $authEmployee = \App\Models\Employee::where('user_id', auth()->id())->first();
                @endphp
                @if($leave->status === 'pending' && $authEmployee && $leave->employee_id === $authEmployee->id)
                <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 10px;">
                    <form action="{{ route('leaves.cancel', $leave) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this leave request?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="hrp-btn hrp-btn-danger">
                            <i class="fa fa-times"></i> Cancel Leave Request
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
}
.badge--success { background-color: #d1fae5; color: #065f46; }
.badge--danger { background-color: #fee2e2; color: #991b1b; }
.badge--warning { background-color: #fef3c7; color: #92400e; }
</style>
@endsection

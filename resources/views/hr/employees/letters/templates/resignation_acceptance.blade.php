<div class="letter-header">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 13px;">
        <div><b>Ref No.:</b> {{ $letter->reference_number }}</div>
        <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
    </div>
    <div class="recipient" style="margin-bottom: 12px; font-size: 13px;">
        <div><b>To,</b></div>
        <div>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</div>
        <div>{{ $employee->designation ?? $employee->position ?? 'Employee' }}</div>
        @if($employee->address)
        <div>{{ $employee->address }}</div>
        @endif
    </div>
</div>

@if($letter->subject)
<div class="subject" style="font-size: 13px;">Subject: {{ $letter->subject }}</div>
@else
<div class="subject" style="font-size: 13px;">Subject: Resignation Acceptance</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    <p>This is to acknowledge receipt of your resignation letter dated <span class="highlight"><b>{{ $letter->resignation_date ? \Carbon\Carbon::parse($letter->resignation_date)->format('d-m-Y') : '___________' }}</b></span>.</p>
    
    <p>We hereby accept your resignation from the position of <b>{{ $employee->designation ?? 'your current position' }}</b> at <span class="company">{{ $company_name }}</span>.</p>

    @if($letter->use_default_content ?? true)
    <p><b>Resignation Details:</b></p>
    <ul>
        @if($letter->last_working_day)
        <li><b>Last Working Day:</b> {{ \Carbon\Carbon::parse($letter->last_working_day)->format('d-m-Y') }}</li>
        @endif
        @if($letter->notice_period)
        <li><b>Notice Period:</b> {{ $letter->notice_period }}</li>
        @endif
    </ul>

    <p>Please ensure the following before your last working day:</p>
    <ul>
        <li>Complete handover of all ongoing projects and responsibilities</li>
        <li>Return all company property including ID card, laptop, and other assets</li>
        <li>Clear all pending dues and settlements</li>
        <li>Complete exit formalities with HR department</li>
    </ul>

    <p>We appreciate your contributions during your tenure with us and wish you success in your future endeavors.</p>
    @endif
    
    @if(!empty($letter->content))
        {!! $letter->content !!}
    @endif
</div>

<div class="signature">
    <div><b>Best Regards,</b></div>
    <div class="sign">
        <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

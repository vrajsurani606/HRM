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
<div class="subject" style="font-size: 13px;">Subject: Appointment / Joining Letter</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    @if($letter->use_default_content ?? true)
        <p>We are pleased to confirm your appointment as <b>{{ $employee->designation }}</b> at 
        <b>{{ $company_name }}</b>. Your joining date and other details will be communicated to you 
        by the HR department. We look forward to your valuable contribution to our organization.</p>
        
        <p>Please report to the HR department on your joining date for further formalities.</p>
    @endif
    
    @if($letter->content)
        {!! $letter->content !!}
    @endif
    
{{-- Notes are for internal use only and should not appear in printed letters --}}

</div>

<div class="signature">
    <div><b>Sincerely,</b></div>
    <div class="sign">
    <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Authorized Signatory' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
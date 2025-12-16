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
<div class="subject" style="font-size: 13px;">Subject: Employment Agreement</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    @if($letter->use_default_content ?? true)
        <p>This letter serves as an employment agreement between you and <b>{{ $company_name }}</b>. 
        As <b>{{ $employee->designation }}</b>, you agree to abide by all company policies, 
        procedures, and terms of employment as outlined in your employment contract.</p>
        
        <p>Please review the terms carefully and sign a copy of this agreement to confirm your acceptance.</p>
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
    <div class="name">{{ $signatory_name ?? 'HR Manager' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

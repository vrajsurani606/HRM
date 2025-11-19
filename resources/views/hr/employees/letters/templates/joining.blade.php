<div class="letter-meta">
    <div><b>Letter No:</b> {{ $letter->reference_number }}</div>
    <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d F Y') }}</div>
</div>

<div class="recipient">
    <div><b>To,</b></div>
    <div>{{ $employee->name }}</div>
    @if($employee->address)
    <div>Address :- {{ $employee->address }}</div>
    @endif
</div>

<div class="subject">Subject: Appointment / Joining Letter</div>

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    <p>We are pleased to confirm your appointment as <b>{{ $employee->designation }}</b> at 
    <b>{{ $company_name }}</b>. Your joining date and other details will be communicated to you 
    by the HR department. We look forward to your valuable contribution to our organization.</p>
    
    <p>Please report to the HR department on your joining date for further formalities.</p>
    
@php
    $cleanNotes = trim(strip_tags($letter->notes));
@endphp

@if(!empty($cleanNotes))
    <div class="note-rectangle">
        <b>Note: {!! strip_tags($letter->notes) !!}</b>
    </div>
@endif

</div>

<div class="signature">
    <div><b>Sincerely,</b></div>
    <div class="sign">
    <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Authorized Signatory' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
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

<div class="subject">Subject: Confidentiality Agreement</div>

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    <p>This agreement is to confirm that as a <b>{{ $employee->designation }}</b> at 
    <b>{{ $company_name }}</b>, you are required to maintain strict confidentiality 
    regarding all company information, data, and intellectual property you may access 
    during your employment. Disclosure of any such information to unauthorized persons 
    is strictly prohibited.</p>
 @php
    $cleanNotes = trim(strip_tags($letter->notes));
@endphp

@if(!empty($cleanNotes))
    <div class="note-rectangle">
        <b>Note: {!! strip_tags($letter->notes) !!}</b>
    </div>
@endif

    
    <p>Kindly sign and return a copy of this letter as your acceptance of the confidentiality terms.</p>
</div>

<div class="signature">
    <div><b>Sincerely,</b></div>
    <div class="sign">
    <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'HR Department' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
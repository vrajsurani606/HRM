<div class="letter-meta">
    <div><b>Ref No.:</b> {{ $letter->reference_number ?? 'REF001' }}</div>
    <div><b>Date:</b> {{ $letter->issue_date ? $letter->issue_date->format('d-m-Y') : date('d-m-Y') }}</div>
</div>

<div class="recipient">
    <div><b>To,</b></div>
    <div>{{ $employee->name }}</div>
    @if($employee->address)
    <div>Address :- {{ $employee->address }}</div>
    @endif
</div>

@if($letter->subject)
<div class="subject">Subject: {{ $letter->subject }}</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    @if($letter->content)
        {!! $letter->content !!}
    @else
        <p>This is a custom letter.</p>
    @endif
    
    @php
        $cleanNotes = trim(strip_tags($letter->notes ?? ''));
    @endphp
    
    @if(!empty($cleanNotes))
        <div class="note-rectangle">
            <b>Note:</b> {!! strip_tags($letter->notes) !!}
        </div>
    @endif
</div>

<div class="signature">
    <div><b>Sincerely,</b></div>
    <div class="sign">
        <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.' }}</div>
</div>
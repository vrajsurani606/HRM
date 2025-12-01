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

@if($letter->subject)
<div class="subject">Subject: {{ $letter->subject }}</div>
@else
<div class="subject">Subject: Employment Agreement</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    @if($letter->content)
        {!! $letter->content !!}
    @else
        <p>This letter serves as an employment agreement between you and <b>{{ $company_name }}</b>. 
        As <b>{{ $employee->designation }}</b>, you agree to abide by all company policies, 
        procedures, and terms of employment as outlined in your employment contract.</p>
        
        <p>Please review the terms carefully and sign a copy of this agreement to confirm your acceptance.</p>
    @endif
    
  @php
    $cleanNotes = trim(strip_tags($letter->notes ?? ''));
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
    <div class="name">{{ $signatory_name ?? 'HR Manager' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

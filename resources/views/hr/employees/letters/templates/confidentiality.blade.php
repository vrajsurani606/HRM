<div class="letter-header">
    <div style="margin-bottom: 15px;"><b>Ref No.:</b> {{ $letter->reference_number }}</div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
        <div class="recipient" style="flex: 1;">
            <div><b>To,</b></div>
            <div>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</div>
            <div>{{ $employee->designation ?? $employee->position ?? 'Employee' }}</div>
            @if($employee->address)
            <div>{{ $employee->address }}</div>
            @endif
        </div>
        <div class="letter-meta" style="text-align: right;">
            <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
        </div>
    </div>
</div>

@if($letter->subject)
<div class="subject">Subject: {{ $letter->subject }}</div>
@else
<div class="subject">Subject: Confidentiality Agreement</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    @if($letter->use_default_content ?? true)
        <p>This agreement is to confirm that as a <b>{{ $employee->designation }}</b> at 
        <b>{{ $company_name }}</b>, you are required to maintain strict confidentiality 
        regarding all company information, data, and intellectual property you may access 
        during your employment. Disclosure of any such information to unauthorized persons 
        is strictly prohibited.</p>
        
        <p>Kindly sign and return a copy of this letter as your acceptance of the confidentiality terms.</p>
    @endif
    
    @if($letter->content)
        {!! $letter->content !!}
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
    <div class="name">{{ $signatory_name ?? 'HR Department' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
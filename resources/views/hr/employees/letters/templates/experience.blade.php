<div class="letter-meta">
    <div><b>Letter No:</b> {{ $letter->reference_number }}</div>
    <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d F Y') }}</div>
</div>

<div class="recipient">
    <div><b>To Whom It May Concern,</b></div>
</div>

<div class="subject">Subject: Experience Certificate</div>

<div class="body">
    @php
        $startDate = \Carbon\Carbon::parse($letter->start_date ?? $employee->joining_date);
        $endDate = \Carbon\Carbon::parse($letter->end_date ?? now());
        
        $startDateFormatted = $startDate->format('d/m/Y');
        $endDateFormatted = $endDate->format('d/m/Y');
    @endphp
    
    <p>This is to certify that <b>{{ $employee->name }}</b> was employed with <b>{{ $company_name }}</b> 
    as <b>{{ $employee->position ?? 'Employee' }}</b> from <b>{{ $startDateFormatted }}</b> to <b>{{ $endDateFormatted }}</b> 
    ({{ $letter->duration }}). During their tenure, they demonstrated professionalism, 
    dedication, and a positive attitude towards their work. We wish them all the best in their future endeavors.</p>
    
@php
    $cleanNotes = trim(strip_tags($letter->notes));
@endphp

@if(!empty($cleanNotes))
    <div class="note-rectangle">
        <b>Note: {!! strip_tags($letter->notes) !!}</b>
    </div>
@endif

    
    <p>For any further information, please feel free to contact us.</p>
</div>

<div class="signature">
    <div><b>Sincerely,</b></div>
    <div class="sign">
    <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Authorized Signatory' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
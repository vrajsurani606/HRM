<div class="letter-meta">
    <div><b>Letter No:</b> {{ $letter->reference_number }}</div>
    <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d/m/Y') }}</div>
</div>

<div class="recipient">
    <div><b>To:</b> {{ $employee->name }}</div>
    <div><b>Designation:</b> {{ $employee->position ?? 'Employee' }}</div>
    <div><b>Address:</b> {{ $employee->address ?? 'N/A' }}</div>
</div>

@if($letter->subject)
<div class="subject">Subject: {{ $letter->subject }}</div>
@else
<div class="subject">Subject: Experience Certificate</div>
@endif

<div class="body">
    <p><b>TO WHOM IT MAY CONCERN</b></p>
    
    @php
        $startDate = \Carbon\Carbon::parse($letter->start_date ?? $employee->joining_date);
        $endDate = $letter->end_date ? \Carbon\Carbon::parse($letter->end_date) : null;
        
        $startDateFormatted = $startDate->format('jS F Y');
        $endDateFormatted = $endDate ? $endDate->format('jS F Y') : 'Current';
    @endphp
    
    @if($letter->content)
        {!! $letter->content !!}
    @else
        <p>This is to certify that <b>{{ $employee->name }}</b> is employed with <b>{{ $company_name }}</b> 
        as a <b>{{ $employee->position ?? 'Employee' }}</b> from <b>{{ $startDateFormatted }}</b> to <b>{{ $endDateFormatted }}</b>.</p>
        
        <p>During this period, {{ $employee->gender === 'Female' ? 'she' : 'he' }} demonstrated professionalism, dedication, and a strong work ethic in all assigned responsibilities. <b>{{ $employee->name }}</b> is involved in the design, development, testing, and maintenance of {{ $employee->position ?? 'assigned projects' }}, and consistently contributed to the team's success.</p>
        
        <p>{{ $employee->gender === 'Female' ? 'She' : 'He' }} maintained good relationships with colleagues and clients, and is known for punctuality and problem-solving skills. We found {{ $employee->gender === 'Female' ? 'her' : 'him' }} to be trustworthy and sincere in all duties.</p>
        
        <p>We wish <b>{{ $employee->name }}</b> all the best in {{ $employee->gender === 'Female' ? 'her' : 'his' }} future endeavors.</p>
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
    <div class="name">{{ $signatory_name ?? 'Authorized Signatory' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

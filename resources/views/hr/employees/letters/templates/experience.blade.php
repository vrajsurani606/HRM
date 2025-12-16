
<style>
    * {
        font-family: 'Poppins', sans-serif;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.6;
        color: #333;
    }
    
    .letter-header, .recipient, .subject, .body, .signature {
        font-family: 'Poppins', sans-serif;
    }
    
    .subject {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 16px;
        text-align: center;
        margin: 20px 0;
    }
    
    .body p {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        margin: 10px 0;
        text-align: justify;
    }
    
    b, strong {
        font-family: 'Poppins', sans-serif;
        font-weight: 700 !important;
    }
    
    .letter-header b, .recipient b, .body b {
        font-family: 'Poppins', sans-serif;
        font-weight: 700 !important;
    }
    
    .signature {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
    }
    
    .signature b {
        font-family: 'Poppins', sans-serif;
        font-weight: 700 !important;
    }
    

</style>

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
<div class="subject" style="font-size: 13px;">Subject: Experience Certificate</div>
@endif

<div class="body">
    <p><b>TO WHOM IT MAY CONCERN</b></p>
    
    @php
        $startDate = \Carbon\Carbon::parse($letter->start_date ?? $employee->joining_date);
        
        // Simple and robust end_date handling
        $endDate = null;
        
        // Check if end_date exists and has a value
        if (!empty($letter->end_date)) {
            try {
                // Since the model has date casting, this should work directly
                $endDate = $letter->end_date instanceof \Carbon\Carbon ? $letter->end_date : \Carbon\Carbon::parse($letter->end_date);
                
                // Additional check: if the date is in the past or future, it's valid
                // If it's 1970-01-01 or similar invalid dates, ignore it
                if ($endDate->year < 1990 || $endDate->year > 2100) {
                    $endDate = null;
                }
            } catch (Exception $e) {
                // If parsing fails, set to null
                $endDate = null;
            }
        }
        
        $startDateFormatted = $startDate->format('jS F Y');
        $endDateFormatted = $endDate ? $endDate->format('jS F Y') : 'Current';
        
        // Determine employment status text
        $employmentStatus = $endDate ? 'was employed' : 'is employed';
        $employmentPeriod = $endDate ? "from <b>{$startDateFormatted}</b> to <b>{$endDateFormatted}</b>" : "from <b>{$startDateFormatted}</b> to <b>Current</b>";
    @endphp
    

    

    
    @if($letter->use_default_content ?? true)
        <p>This is to certify that <b>{{ $employee->name }}</b> {{ $employmentStatus }} with <b>{{ $company_name }}</b> 
        as a <b>{{ $employee->position ?? 'Employee' }}</b> {!! $employmentPeriod !!}.</p>
        
        <p>During this period, {{ $employee->gender === 'Female' ? 'she' : 'he' }} demonstrated professionalism, dedication, and a strong work ethic in all assigned responsibilities. {{ $employee->name }} is involved in the design, development, testing, and maintenance of {{ $employee->position ?? 'assigned projects' }}, and consistently contributed to the team's success.</p>
        
        <p>{{ $employee->gender === 'Female' ? 'She' : 'He' }} maintained good relationships with colleagues and clients, and is known for punctuality and problem-solving skills. We found {{ $employee->gender === 'Female' ? 'her' : 'him' }} to be trustworthy and sincere in all duties.</p>
        
        <p>We wish {{ $employee->name }} all the best in {{ $employee->gender === 'Female' ? 'her' : 'his' }} future endeavors.</p>
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

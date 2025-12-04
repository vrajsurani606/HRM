<style>
    .probation-section ul, .salary-section ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    .probation-section li, .salary-section li {
        margin-bottom: 5px;
        line-height: 1.4;
    }
    .letter-header {
        margin-bottom: 20px;
    }
    .letter-header h2 {
        margin: 0 0 10px 0;
        text-align: center;
    }
    .letter-header p {
        margin: 5px 0;
    }
</style>

<div class="letter-header">
    <div style="margin-bottom: 15px;"><b>Ref No.:</b> {{ $letter->reference_number ?? 'N/A' }}</div>
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
            <div><b>Date:</b> {{ $letter->issue_date ? \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') : now()->format('d-m-Y') }}</div>
        </div>
    </div>
</div>

<div class="subject">Subject: Job Offer for {{ $employee->position ?? $employee->designation ?? 'N/A' }} Position</div>

    <div class="body">
        <p>Dear <b>{{ $employee->name }}</b>,</p>
        
        <p><b>Congratulations!</b> We are pleased to offer you the position of <strong>{{ $employee->position ?? $employee->designation ?? 'N/A' }}</strong> at our company.</p>
        
        @if($letter->monthly_salary || $letter->annual_ctc)
        <p><b>Compensation:</b></p>
        <ul>
            @if($letter->monthly_salary)
            <li><b>Monthly Salary:</b> ₹{{ number_format($letter->monthly_salary, 2) }}</li>
            @endif
            @if($letter->annual_ctc)
            <li><b>Annual CTC:</b> ₹{{ number_format($letter->annual_ctc, 2) }}</li>
            @endif
        </ul>
        @endif
        
        @if($letter->date_of_joining)
        <p>Your expected joining date is <strong>{{ \Carbon\Carbon::parse($letter->date_of_joining)->format('d/m/Y') }}</strong>.</p>
        @elseif($employee->joining_date)
        <p>Your expected joining date is <strong>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d/m/Y') }}</strong>.</p>
        @endif
        
        @if($letter->reporting_manager)
        <p><b>Reporting Manager:</b> {{ $letter->reporting_manager }}</p>
        @endif
        
        @if($letter->working_hours)
        <p><b>Working Hours:</b> {{ $letter->working_hours }}</p>
        @endif
        
        @php
            $probation = $letter->probation_period;
            $salary_increment = $letter->salary_increment;
            $probation_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($probation ?? '')), function($v){ return trim($v) !== ''; }));
            $salary_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($salary_increment ?? '')), function($v){ return trim($v) !== ''; }));
        @endphp
        
        @if(!empty($probation_lines))
            <div class="probation-section">
                <p><strong>Probation Period:</strong></p>
                <ul class="bullets-avoid-break">
                    @foreach($probation_lines as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(!empty($salary_lines))
            <div class="salary-section">
                <p><strong>Salary & Increment Structure:</strong></p>
                <ul class="bullets-avoid-break">
                    @foreach($salary_lines as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(!empty($letter->content))
        <div class="additional-content">
            {!! $letter->content !!}
        </div>
        @endif
        
        <p>We look forward to your positive response and to welcoming you to our team.</p>
        
        @php
            $cleanNotes = trim(strip_tags($letter->notes ?? ''));
        @endphp
        
        @if(!empty($cleanNotes))
            <div class="note-rectangle">
                <b>Note: {!! strip_tags($letter->notes) !!}</b>
            </div>
        @endif
        
        <div class="signature-section">
            <p>Sincerely,</p>
            <br><br>
            <p>HR Department</p>
        </div>
    </div>
</div>
<div class="letter-header">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 13px;">
        <div><b>Ref No.:</b> {{ $letter->reference_number }}</div>
        <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
    </div>
    <div class="recipient" style="margin-bottom: 12px; font-size: 13px;">
        <div><b>To Whom It May Concern,</b></div>
    </div>
</div>

@if($letter->subject)
<div class="subject" style="font-size: 13px;">Subject: {{ $letter->subject }}</div>
@else
<div class="subject" style="font-size: 13px;">Subject: Salary Certificate</div>
@endif

<div class="body">
    <p>This is to certify that <b>{{ $employee->name ?? 'N/A' }}</b> is a confirmed employee of <span class="company">{{ $company_name }}</span>.</p>
    
    <p><b>Employee Details:</b></p>
    <ul>
        <li><b>Employee Name:</b> {{ $employee->name ?? 'N/A' }}</li>
        <li><b>Employee ID:</b> {{ $employee->employee_id ?? 'N/A' }}</li>
        <li><b>Designation:</b> {{ $employee->designation ?? $employee->position ?? 'Employee' }}</li>
        <li><b>Department:</b> {{ $employee->department ?? 'As assigned' }}</li>
        <li><b>Date of Joining:</b> {{ $employee && $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d-m-Y') : 'As per records' }}</li>
    </ul>

    @if($letter->monthly_salary || $letter->annual_ctc)
    <p><b>Salary Details:</b></p>
    <ul>
        @if($letter->monthly_salary)
        <li><b>Current Monthly Salary:</b> ₹{{ number_format($letter->monthly_salary, 2) }}</li>
        @endif
        @if($letter->annual_ctc)
        <li><b>Annual CTC:</b> ₹{{ number_format($letter->annual_ctc, 2) }}</li>
        @endif
    </ul>
    @endif

    @if($letter->use_default_content ?? true)
    <p>This certificate is issued upon the request of the employee for official purposes.</p>
    <p>This certificate is valid as of the date mentioned above.</p>
    @endif
    
    @if($letter->content)
        {!! $letter->content !!}
    @endif
</div>

<div class="signature">
    <div><b>For {{ $company_name }},</b></div>
    <div class="sign">
        <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

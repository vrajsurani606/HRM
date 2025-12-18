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
<div class="subject" style="font-size: 13px;">Subject: Promotion Letter</div>
@endif

<div class="body">
    <p>Dear <b>{{ $employee->name }}</b>,</p>
    
    <p>We are pleased to inform you that based on your excellent performance and dedication, you have been promoted in <span class="company">{{ $company_name }}</span>.</p>
    
    @if($letter->use_default_content ?? true)
    <p><b>Your promotion details are as follows:</b></p>
    <ul>
        <li><b>Current Designation:</b> {{ $employee->designation ?? 'Current Position' }}</li>
        @if($letter->new_designation)
        <li><b>New Designation:</b> {{ $letter->new_designation }}</li>
        @endif
        @if($letter->effective_date)
        <li><b>Effective Date:</b> {{ \Carbon\Carbon::parse($letter->effective_date)->format('d-m-Y') }}</li>
        @endif
        @if($letter->new_salary)
        <li><b>New Salary:</b> ₹{{ number_format($letter->new_salary, 2) }}</li>
        @endif
        @if($letter->reporting_manager)
        <li><b>Reporting Manager:</b> {{ $letter->reporting_manager }}</li>
        @endif
    </ul>

    <p>This promotion is in recognition of your hard work, commitment, and valuable contributions to the organization. We are confident that you will continue to excel in your new role and contribute to the company's growth.</p>

    <p>Please report to the HR department to complete the necessary formalities related to your promotion.</p>

    <p>Congratulations on your well-deserved promotion!</p>
    @endif
    
    @if(!empty($letter->content))
        {!! $letter->content !!}
    @endif
</div>

<div class="signature">
    <div><b>Best Regards,</b></div>
    <div class="sign">
        <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

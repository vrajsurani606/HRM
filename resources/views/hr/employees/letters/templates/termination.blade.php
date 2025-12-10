@php
    $employee = $letter->employee;
@endphp
<div class="letter-header">
    <div style="margin-bottom: 15px;"><b>Ref No.:</b> {{ $letter->reference_number }}</div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
        <div class="recipient" style="flex: 1;">
            <div><b>To,</b></div>
            <div>{{ (($employee->gender ?? '') == 'Female' || ($employee->gender ?? '') == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name ?? 'N/A' }}</div>
            <div>{{ $employee->designation ?? $employee->position ?? 'Employee' }}</div>
            @if($employee && $employee->address)
            <div>{{ $employee->address }}</div>
            @endif
        </div>
        <div class="letter-meta" style="text-align: right;">
            <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
        </div>
    </div>
</div>

<div class="subject">Subject: Termination Letter</div>

<div class="body">
<p>Dear <b>{{ $employee->name ?? 'Employee' }}</b>,</p>

@if($letter->use_default_content ?? true)
    <p>This letter is to formally notify you that your employment with <span class="company">{{ $company_name }}</span> will be terminated effective <b>{{ $letter->end_date ? $letter->end_date->format('F d, Y') : '_______________' }}</b>, due to consistently low performance despite prior discussions and performance improvement plans.</p>

    <p>Over the past few months, we have reviewed your work and provided feedback and support to help you meet the expected performance standards. Unfortunately, there has not been sufficient improvement in your overall performance to meet the company's requirements for your role.</p>

    <p>Your final settlement, including any pending salary (if applicable), will be processed and credited as per company policy. Please ensure that all company assets, files, and credentials in your possession are returned to the HR department by your last working day.</p>
@endif

@if(!empty($letter->content))
    {!! $letter->content !!}
@endif

{{-- Notes are for internal use only and should not appear in printed letters --}}

<p>We appreciate the efforts you have made during your time with us and wish you the best in your future endeavors.</p>
</div>
<div class="signature">
    <div><b>Sincerely,</b></div>
    <div class="sign">
    <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
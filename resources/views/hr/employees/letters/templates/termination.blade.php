<div class="recipient">
    <div><b>To,</b></div>
    <div><b>{{ strtoupper($letter->employee->name) }}</b></div>
    @if($letter->employee->address)
    <div>{{ $letter->employee->address }}</div>
    @endif
</div>

<div style="margin: 20px 0;">
    <div><b>Date:</b> {{ $letter->issue_date ? $letter->issue_date->format('d.m.Y') : date('d.m.Y') }}</div>
</div>

<div class="subject">Subject: Termination letter from designation of {{ $letter->employee->position ?? 'Employee' }}</div>

<div class="body">
<p>Dear <b>{{ $letter->employee->name }}</b>,</p>
@php
    $content = trim(strip_tags($letter->content ?? ''));
@endphp

<p>This letter is to formally notify you that your employment with <span class="company">{{ $company_name }}</span> will be terminated effective <b> {{ $letter->end_date ? $letter->end_date->format('F d, Y') : '_______________' }},</b> due to <b>{{ $content ?? 'consistently low performance despite prior discussions and performance improvement plans' }}.</b></p>

<p>Over the past few months, we have reviewed your work and provided feedback and support to help you meet the expected performance standards. Unfortunately, there has not been sufficient improvement in your overall performance to meet the company's requirements for your role.</p>

<p>Your final settlement, including any pending salary (if applicable), will be processed and credited as per company policy. Please ensure that all company assets, files, and credentials in your possession are returned to the HR department by your last working day.</p>

@php
    $cleanNotes = trim(strip_tags($letter->notes ?? ''));
@endphp

@if(!empty($cleanNotes))
    <div class="note-rectangle">
        <b>Note: {!! strip_tags($letter->notes) !!}</b>
    </div>
@endif

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
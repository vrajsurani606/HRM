<div class="letter-meta">
    <div><b>Ref No.:</b> {{ $letter->reference_number ?? 'REF001' }}</div>
    <div><b>Date:</b> {{ $letter->issue_date ? $letter->issue_date->format('d-m-Y') : date('d-m-Y') }}</div>
</div>
<div class="recipient">
    <div><b>To,</b></div>
    <div>{{ $letter->employee->name }}</div>
    @if($letter->employee->address)
    <div>Address :- {{ $letter->employee->address }}</div>
    @endif
</div>
<div class="subject">Subject: Warning Notice</div>
<div class="body">
<p>Dear <b>{{ $letter->employee->name }}</b>,</p>

<p>This letter serves as a <b>Warning Notice</b> regarding your conduct/performance at <span class="company">{{ $company_name }}</span>.</p>

@if(!empty($letter->content))
    {!! $letter->content !!}
@else

    <p><b>Issue Details:</b></p>
    <p>We have observed the following concerns that require immediate attention and improvement:</p>
    <ul style="list-style-type: disc; margin: 4px 0 0 18px; padding:0;">
        <li>Details of the issue will be specified based on the specific case</li>
        <li>Date and time of occurrence (if applicable)</li>
        <li>Impact on work/team/organization</li>
    </ul>
@endif
    <p><b>Expected Improvement:</b></p>
    <ol style="margin-top: 4px;">
        <li>Immediate correction of the identified issues</li>
        <li>Adherence to company policies and procedures</li>
        <li>Improvement in performance/conduct within the specified timeframe</li>
        <li>Regular monitoring and feedback sessions with your supervisor</li>
    </ol>

    <p><b>Consequences:</b></p>
    <p>Please note that failure to show improvement may result in further disciplinary action, including but not limited to suspension or termination of employment.</p>

    <p><b>Support:</b></p>
    <p>The company is committed to supporting your improvement. Please feel free to discuss any challenges or seek guidance from your supervisor or HR department.</p>

    <p>We trust that you will take this matter seriously and work towards immediate improvement.</p>


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
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>
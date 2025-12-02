<div class="letter-meta">
    <div><b>Letter No:</b> {{ $letter->reference_number }}</div>
    <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d F Y') }}</div>
</div>

<div class="recipient">
    <div><b>To,</b></div>
    <div>{{ $employee->name }}</div>
    @if($letter->internship_address)
    <div>{{ $letter->internship_address }}</div>
    @elseif($employee->address)
    <div>{{ $employee->address }}</div>
    @endif
</div>

@if($letter->subject)
<div class="subject">Subject: {{ $letter->subject }}</div>
@else
<div class="subject">Subject: Internship Offer Letter</div>
@endif

<div class="body">
    <p><strong>Dear {{ $employee->name }},</strong></p>

    <p>We are pleased to offer you an internship opportunity with <strong>{{ $company_name }}</strong>. The details of your internship are as follows:</p>

    <p><strong>Internship Details:</strong></p>
    <ul>
        <li><strong>Position:</strong> {{ $letter->internship_position ?? 'Intern' }}</li>
        @if($letter->internship_start_date)
        <li><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($letter->internship_start_date)->format('d F Y') }}</li>
        @endif
        @if($letter->internship_end_date)
        <li><strong>End Date:</strong> {{ \Carbon\Carbon::parse($letter->internship_end_date)->format('d F Y') }}</li>
        @endif
        @if($letter->internship_start_date && $letter->internship_end_date)
        @php
            $start = \Carbon\Carbon::parse($letter->internship_start_date);
            $end = \Carbon\Carbon::parse($letter->internship_end_date);
            $duration = $start->diffInMonths($end);
        @endphp
        <li><strong>Duration:</strong> {{ $duration }} month{{ $duration != 1 ? 's' : '' }}</li>
        @endif
    </ul>

    @if(!empty($letter->content))
        {!! $letter->content !!}
    @else

        <p>This internship is designed to provide you with practical experience and skill development in your field. The internship period is structured to help you gain valuable industry exposure while contributing to our organization.</p>

        <p><strong>During your internship, you will:</strong></p>
        <ul>
            <li>Work under the guidance of your assigned mentor and team members</li>
            <li>Follow company rules, working hours, and maintain professional discipline</li>
            <li>Gain practical exposure in your respective field through real projects</li>
            <li>Participate in training sessions and skill development programs</li>
            <li>Learn industry best practices and professional work ethics</li>
        </ul>

        <p><strong>Terms and Conditions:</strong></p>
        <ul>
            <li>You are expected to maintain regular attendance and punctuality</li>
            <li>Adherence to company policies and code of conduct is mandatory</li>
            <li>Any leave during the internship period must be approved in advance</li>
            <li>Performance will be evaluated periodically throughout the internship</li>
        </ul>

        <p>Based on your performance during the internship, you may be considered for a permanent position with our organization.</p>

        <p>We look forward to your contribution and growth with <strong>{{ $company_name }}</strong>.</p>
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
    <div><b>Warm regards,</b></div>
    <div class="sign">
        <img src="{{ asset('letters/signature.png') }}" alt="Signature">
    </div>
    <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
    <div class="company">{{ $company_name }}</div>
</div>

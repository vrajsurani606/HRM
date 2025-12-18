<div class="letter-header">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 13px;">
        <div><b>Ref No.:</b> {{ $letter->reference_number }}</div>
        <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
    </div>
    <div class="recipient" style="margin-bottom: 12px; font-size: 13px;">
        <div><b>To,</b></div>
        <div>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</div>
        <div>{{ $employee->designation ?? $employee->position ?? 'Intern' }}</div>
        @if($employee->address)
        <div>{{ $employee->address }}</div>
        @endif
    </div>
</div>

@if($letter->subject)
<div class="subject" style="font-size: 13px;">Subject: {{ $letter->subject }}</div>
@else
<div class="subject" style="font-size: 13px;">Subject: Internship Completion Certificate</div>
@endif

<div class="body">
    <p>This is to certify that <strong>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</strong> has successfully completed the Internship Program at <strong>{{ $company_name }}</strong>.</p>

    <p><strong>{{ $employee->name }}</strong> worked with our company as an Intern in the <strong>{{ $letter->internship_position ?? $employee->position ?? 'Developer' }}</strong> position 
    @if($letter->internship_start_date && $letter->internship_end_date)
        from <strong>{{ \Carbon\Carbon::parse($letter->internship_start_date)->format('d F Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($letter->internship_end_date)->format('d F Y') }}</strong>.
    @elseif($letter->internship_start_date)
        starting from <strong>{{ \Carbon\Carbon::parse($letter->internship_start_date)->format('d F Y') }}</strong>.
    @else
        with our organization.
    @endif
    </p>

    @if($letter->use_default_content ?? true)
        <p><strong>During the internship period, {{ $employee->gender == 'female' || $employee->gender == 'Female' ? 'she' : 'he' }} has been involved in:</strong></p>
        <ul>
            <li>Assisting the team with project-related tasks</li>
            <li>Learning and implementing new technical skills</li>
            <li>Supporting ongoing software development activities</li>
            <li>Maintaining good discipline, punctuality, and professionalism</li>
        </ul>

        <p>We appreciate {{ $employee->gender == 'female' || $employee->gender == 'Female' ? 'her' : 'his' }} contribution to the company and wish {{ $employee->gender == 'female' || $employee->gender == 'Female' ? 'her' : 'him' }} success in {{ $employee->gender == 'female' || $employee->gender == 'Female' ? 'her' : 'his' }} future career.</p>
    @endif
    
    @if(!empty($letter->content))
        {!! $letter->content !!}
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

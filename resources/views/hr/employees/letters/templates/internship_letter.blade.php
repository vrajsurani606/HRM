    <div class="letter-header">
        <div style="margin-bottom: 15px;"><b>Ref No.:</b> {{ $letter->reference_number }}</div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <div class="recipient" style="flex: 1;">
                <div><b>To,</b></div>
                <div>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</div>
                <div>{{ $employee->designation ?? $employee->position ?? 'Intern' }}</div>
                @if($employee->address)
                <div>{{ $employee->address }}</div>
                @endif
            </div>
            <div class="letter-meta" style="text-align: right;">
                <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
            </div>
        </div>
    </div>
    <div class="subject">Subject: Internship Letter for {{ $employee->name }} </div>

<div class="body">
        <p>This is to certify that <strong>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</strong> has successfully completed the Internship Program at <strong>{{ $company_name ?? 'Chitri Enlargesoft Pvt. Ltd.' }}</strong></p>

        <p><strong>{{ $employee->name }}</strong> worked with our company as an Intern in the <strong>{{ $letter->internship_position ?? 'Developer' }}</strong> position 
        @if($letter->internship_start_date && $letter->internship_end_date)
            from <strong>{{ $letter->internship_start_date->format('d F Y') }}</strong> to <strong>{{ $letter->internship_end_date->format('d F Y') }}</strong>.
        @elseif($letter->internship_start_date)
            starting from <strong>{{ $letter->internship_start_date->format('d F Y') }}</strong> and is currently continuing the internship with us.
        @else
            with our organization.
        @endif
        </p>

        @if($letter->use_default_content ?? true)
            <p><strong>During the internship period, {{ $employee->gender == 'female' ? 'she' : 'he' }} has been involved in:</strong></p>
            <ul>
                <li>Assisting the team with project-related tasks</li>
                <li>Learning and implementing new technical skills</li>
                <li>Supporting ongoing software development activities</li>
                <li>Maintaining good discipline, punctuality, and professionalism</li>
            </ul>

            <p>We appreciate {{ $employee->gender == 'female' ? 'her' : 'his' }} contribution to the company and wish {{ $employee->gender == 'female' ? 'her' : 'him' }} success in {{ $employee->gender == 'female' ? 'her' : 'his' }} future career.</p>
        @endif
        
        @if(!empty($letter->content))
            {!! $letter->content !!}
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
        <div class="name">{{ $signatory_name ?? 'HR Manager' }}</div>
        <div class="company">{{ $company_name }}</div>
    </div>
</body>

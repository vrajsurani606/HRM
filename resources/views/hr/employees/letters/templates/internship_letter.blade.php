    <div class="letter-meta">
        <div><b>Letter No:</b> {{ $letter->reference_number }}</div>
        <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d F Y') }}</div>
    </div>

    <div class="recipient">
        <div><b>To,</b></div>
        <div>{{ $employee->name }}</div>
        @if($employee->address)
        <div>Address :- {{ $employee->address }}</div>
        @endif
    </div>
    <div class="subject">Subject: Internship Letter for {{ $employee->name }} </div>

<div class="body">
        <p>This is to certify that <strong>Mr./Ms. {{ $employee->name }}</strong> has been selected for the Internship Program at <strong>Chitri Enlargesoft Pvt. Ltd.</strong></p>

        <p><strong>{{ $employee->name }}</strong> has been working with our company as an Intern in the <strong>{{ $letter->internship_position ?? 'Developer' }}</strong> since <strong>{{ $letter->internship_start_date ? $letter->internship_start_date->format('d F Y') : '___________' }}</strong>, and 
        @if($letter->internship_end_date)
            completed the internship on <strong>{{ $letter->internship_end_date->format('d F Y') }}</strong>.
        @else
            is currently continuing the internship with us.
        @endif
        </p>

        <p><strong>During the internship period, {{ $employee->gender == 'female' ? 'she' : 'he' }} has been involved in:</strong></p>
        <ul>
            <li>Assisting the team with project-related tasks</li>
            <li>Learning and implementing new technical skills</li>
            <li>Supporting ongoing software development activities</li>
            <li>Maintaining good discipline, punctuality, and professionalism</li>
        </ul>

        <p>We appreciate {{ $employee->gender == 'female' ? 'her' : 'his' }} contribution to the company and wish {{ $employee->gender == 'female' ? 'her' : 'him' }} success in {{ $employee->gender == 'female' ? 'her' : 'his' }} future career.</p>

       <div class="signature">
            <div><b>Sincerely,</b></div>
            <div class="sign">
            <img src="{{ asset('letters/signature.png') }}" alt="Signature">
            </div>
            <div class="name">{{ $signatory_name ?? 'HR Manager' }}</div>
            <div class="company">{{ $company_name }}</div>
        </div>
    </div>
</body>

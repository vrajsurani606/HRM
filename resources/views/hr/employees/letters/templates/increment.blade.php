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
    <div class="subject">Subject: Salary Increment Letter for {{ $employee->name }} </div>

<div class="body">
        <p><strong>Dear {{ $employee->name }},</strong></p>

        <p>We are pleased to inform you that the management has approved a revision in your monthly salary.</p>

        <p>Effective from <strong>{{ $letter->increment_effective_date ? $letter->increment_effective_date->format('d F Y') : '___________' }}</strong>, your revised monthly salary will be <strong>₹{{ $letter->increment_amount ? number_format($letter->increment_amount) : '_____' }}</strong>.</p>

        <p>This increment has been granted in recognition of your performance, dedication, and contribution to the organization. We appreciate your consistent efforts and look forward to your continued commitment in your role as <strong>{{ $employee->position ?? '_______' }}</strong>.</p>

        <p>If you have any questions regarding this revision, please feel free to contact the management.</p>

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
</html>
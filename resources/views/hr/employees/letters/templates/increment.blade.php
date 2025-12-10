    <div class="letter-header">
        <div style="margin-bottom: 15px;"><b>Ref No.:</b> {{ $letter->reference_number }}</div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <div class="recipient" style="flex: 1;">
                <div><b>To,</b></div>
                <div>{{ ($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</div>
                <div>{{ $employee->designation ?? $employee->position ?? 'Employee' }}</div>
                @if($employee->address)
                <div>{{ $employee->address }}</div>
                @endif
            </div>
            <div class="letter-meta" style="text-align: right;">
                <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
            </div>
        </div>
    </div>
    @if($letter->subject)
    <div class="subject">Subject: {{ $letter->subject }}</div>
    @else
    <div class="subject">Subject: Salary Increment Letter</div>
    @endif

<div class="body">
        <p><strong>Dear {{ $employee->name }},</strong></p>

        @if($letter->use_default_content ?? true)
            <p>We are pleased to inform you that the management has approved a revision in your monthly salary.</p>

            <p>Effective from <strong>{{ $letter->increment_effective_date ? $letter->increment_effective_date->format('d F Y') : '___________' }}</strong>, your revised monthly salary will be <strong>₹{{ $letter->increment_amount ? number_format($letter->increment_amount) : '_____' }}</strong>.</p>

            <p>This increment has been granted in recognition of your performance, dedication, and contribution to the organization. We appreciate your consistent efforts and look forward to your continued commitment in your role as <strong>{{ $employee->position ?? '_______' }}</strong>.</p>

            <p>If you have any questions regarding this revision, please feel free to contact the management.</p>
        @endif
        
        @if($letter->content)
            {!! $letter->content !!}
        @endif
        
        {{-- Notes are for internal use only and should not appear in printed letters --}}

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
<style>
    .probation-section ul, .salary-section ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    .probation-section li, .salary-section li {
        margin-bottom: 5px;
        line-height: 1.4;
    }
</style>

<div class="letter-template">
    <div class="letter-header">
        <h2>OFFER LETTER</h2>
        <p><strong>Reference No:</strong> {{ $letter->reference_number }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d/m/Y') }}</p>
    </div>

    <div class="letter-body">
        <p>Dear {{ $employee->name }},</p>
        
        <p>We are pleased to offer you the position of <strong>{{ $employee->position ?? 'N/A' }}</strong> at our company.</p>
        
        @if($employee->current_offer_amount)
        <p>Your starting salary will be <strong>₹{{ number_format($employee->current_offer_amount, 2) }}</strong> per annum.</p>
        @endif
        
        @if($employee->joining_date)
        <p>Your expected joining date is <strong>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d/m/Y') }}</strong>.</p>
        @endif
        
        @if(!empty($letter->probation_period_array))
            <div class="probation-section">
                <p><strong>Probation Period:</strong></p>
                <ul>
                    @foreach($letter->probation_period_array as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(!empty($letter->salary_increment_array))
            <div class="salary-section">
                <p><strong>Salary Structure:</strong></p>
                <ul>
                    @foreach($letter->salary_increment_array as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="letter-content">
            {!! nl2br(e($letter->content)) !!}
        </div>
        
        <p>We look forward to your positive response and to welcoming you to our team.</p>
        
        @php
            $cleanNotes = trim(strip_tags($letter->notes ?? ''));
        @endphp
        
        @if(!empty($cleanNotes))
            <div class="note-rectangle">
                <b>Note: {!! strip_tags($letter->notes) !!}</b>
            </div>
        @endif
        
        <div class="signature-section">
            <p>Sincerely,</p>
            <br><br>
            <p>HR Department</p>
        </div>
    </div>
</div>
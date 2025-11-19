C

        <p><strong>Dear {{ $employee->name }},</strong></p>

        <p>We are pleased to offer you an internship opportunity with <strong>Chitri Enlargesoft IT Hub Pvt. Ltd.</strong> as a <strong>{{ $letter->internship_position ?? 'Full stack developer' }}</strong>.</p>

        <p>This internship is part of your learning and skill development process. The internship period will continue until the completion of your training and mutual agreement between you and the company.</p>

        <p><strong>During your internship, you will:</strong></p>
        <ul>
            <li>Work under the guidance of your assigned mentor and team.</li>
            <li>Follow company rules, working hours, and discipline.</li>
            <li>Gain practical exposure in your respective field and projects.</li>
        </ul>

        @if($letter->internship_start_date)
        <p><strong>Start Date:</strong> {{ $letter->internship_start_date->format('d F Y') }}</p>
        @endif

        <p>If applicable, you may be considered for a permanent position based on your performance during the internship.</p>

        <p>We look forward to your contribution and growth with our organization.</p>

        <div class="signature">
            <p><strong>Warm regards,</strong></p>
            <br><br>
            <p><strong>Mr. Chintan Kachhadiya</strong><br>
            Chitri Enlargesoft IT Hub Pvt. Ltd.</p>
        </div>
    </div>

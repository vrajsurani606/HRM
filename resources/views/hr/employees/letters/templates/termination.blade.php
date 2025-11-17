<p>Dear <b>{{ $letter->employee->name }}</b>,</p>

<p>This letter serves as formal notice of <b>Termination of Employment</b> with <span class="company">{{ $company_name }}</span>.</p>

<p><b>Termination Details:</b></p>
<ul style="list-style-type: disc; margin: 4px 0 0 18px; padding:0;">
    <li><b>Employee ID:</b> {{ $letter->employee->employee_id }}</li>
    <li><b>Last Working Day:</b> [To be specified]</li>
    <li><b>Reason for Termination:</b> [To be specified based on case]</li>
    <li><b>Notice Period:</b> As per company policy/contract terms</li>
</ul>

<p><b>Final Settlement:</b></p>
<ol style="margin-top: 4px;">
    <li><b>Salary:</b> Final salary will be processed as per company policy</li>
    <li><b>Benefits:</b> All applicable benefits will be calculated and settled</li>
    <li><b>Provident Fund:</b> PF settlement will be processed as per statutory requirements</li>
    <li><b>Gratuity:</b> If applicable, will be processed as per policy</li>
</ol>

<p><b>Return of Company Property:</b></p>
<p>You are required to return all company property including but not limited to:</p>
<ul style="list-style-type: disc; margin: 4px 0 0 18px; padding:0;">
    <li>ID card, access cards, and keys</li>
    <li>Laptop, mobile phone, and other electronic devices</li>
    <li>Documents, files, and confidential information</li>
    <li>Any other company assets in your possession</li>
</ul>

<p><b>Confidentiality:</b></p>
<p>Please note that your confidentiality obligations continue even after termination of employment.</p>

<p>We wish you success in your future endeavors.</p>
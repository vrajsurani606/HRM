<p>Dear <b>{{ $letter->employee->name }}</b>,</p>

<p>This is to certify that <b>{{ $letter->employee->name }}</b> was employed with <span class="company">{{ $company_name }}</span> in the capacity of <b>{{ $letter->employee->designation ?? 'Employee' }}</b>.</p>

<p><b>Employment Details:</b></p>
<ul style="list-style-type: disc; margin: 4px 0 0 18px; padding:0;">
    <li><b>Employee ID:</b> {{ $letter->employee->employee_id }}</li>
    <li><b>Designation:</b> {{ $letter->employee->designation ?? 'As per records' }}</li>
    <li><b>Department:</b> {{ $letter->employee->department ?? 'As per records' }}</li>
    <li><b>Date of Joining:</b> {{ $letter->employee->date_of_joining ? $letter->employee->date_of_joining->format('d-m-Y') : 'As per records' }}</li>
    <li><b>Last Working Day:</b> {{ $letter->employee->last_working_day ? $letter->employee->last_working_day->format('d-m-Y') : 'As applicable' }}</li>
</ul>

<p><b>Performance and Conduct:</b></p>
<p>During the tenure of employment, {{ $letter->employee->name }} has shown dedication, professionalism, and commitment to work. The employee has been found to be hardworking, sincere, and honest in all dealings.</p>

<p>We wish {{ $letter->employee->name }} all the best for future endeavors.</p>

<p>This certificate is issued upon request for official purposes.</p>
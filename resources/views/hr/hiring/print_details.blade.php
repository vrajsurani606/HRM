<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hiring Lead Details - {{ $lead->person_name }}</title>
  <style>
    body, html { margin:0; padding:20px; font-family: Arial, Helvetica, sans-serif; }
    h1{ font-size:18px; margin:0 0 12px; }
    table{ width:100%; border-collapse:collapse; }
    th, td{ text-align:left; border:1px solid #ddd; padding:8px; font-size:14px; }
  </style>
</head>
<body>
  <button onclick="window.print()" style="margin-bottom:12px;">Print</button>
  <h1>Hiring Lead Details</h1>
  <table>
    <tr><th>Unique Code</th><td>{{ $lead->unique_code }}</td></tr>
    <tr><th>Person Name</th><td>{{ $lead->person_name }}</td></tr>
    <tr><th>Mobile</th><td>{{ display_mobile($lead->mobile_no) }}</td></tr>
    <tr><th>Address</th><td>{{ $lead->address }}</td></tr>
    <tr><th>Position</th><td>{{ $lead->position }}</td></tr>
    <tr><th>Is Experience</th><td>{{ $lead->is_experience ? 'Yes' : 'No' }}</td></tr>
    <tr><th>Experience Count</th><td>{{ $lead->experience_count }}</td></tr>
    <tr><th>Previous Company</th><td>{{ $lead->experience_previous_company }}</td></tr>
    <tr><th>Previous Salary</th><td>{{ $lead->previous_salary }}</td></tr>
    <tr><th>Gender</th><td>{{ $lead->gender }}</td></tr>
  </table>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hiring Lead Details - {{ $lead->person_name }}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body, html { margin:0; padding:20px; font-family: Arial, Helvetica, sans-serif; }
    h1{ font-size:18px; margin:0 0 12px; }
    table{ width:100%; border-collapse:collapse; }
    th, td{ text-align:left; border:1px solid #ddd; padding:8px; font-size:14px; }
    .btn-container { margin-bottom:12px; display: flex; gap: 10px; }
    .btn { padding: 8px 14px; border-radius: 4px; cursor: pointer; font-weight: 600; border: none; }
    .btn-back { background: #6b7280; color: #fff; }
    .btn-back:hover { background: #4b5563; }
    .btn-print { background: #1f2937; color: #fff; }
    .btn-print:hover { background: #111827; }
    @media print {
      .btn-container { display: none !important; }
    }
  </style>
</head>
<body>
  <div class="btn-container">
    <button class="btn btn-back" onclick="goBack()">
      <i class="fas fa-arrow-left"></i> Back
    </button>
    <button class="btn btn-print" onclick="window.print()">
      <i class="fas fa-print"></i> Print
    </button>
  </div>
  <script>
  function goBack() {
    const urlParams = new URLSearchParams(window.location.search);
    const redirectTo = urlParams.get('redirect_to');
    if (redirectTo) {
      window.location.href = redirectTo;
    } else if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
      window.history.back();
    } else {
      window.location.href = "{{ route('hiring.index') }}";
    }
  }
  </script>
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

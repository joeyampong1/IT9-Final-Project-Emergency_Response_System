<!DOCTYPE html>
<html>
<head>
    <title>Report Submitted</title>
</head>
<body>
    <h2>Thank you, {{ $report->reporter->name }}!</h2>
    <p>Your emergency report has been successfully submitted.</p>
    <p><strong>Report ID:</strong> #{{ $report->id }}</p>
    <p><strong>Type:</strong> {{ ucfirst($report->type) }}</p>
    <p><strong>Location:</strong> {{ $report->location }}</p>
    <p>Our team will review your report and take appropriate action. You can track the status of your report by logging into your account.</p>
    <a href="{{ url('/reports/'.$report->id) }}">View your report</a>
    <p>Thank you for using the Emergency Response System.</p>
</body>
</html>
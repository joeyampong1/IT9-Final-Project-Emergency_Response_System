<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #dc2626;
            padding: 24px 20px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 30px 24px;
            color: #1f2937;
        }
        .alert-details {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 16px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .alert-details ul {
            margin: 8px 0 0 20px;
            padding-left: 0;
        }
        .alert-details li {
            margin-bottom: 6px;
        }
        .button {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 20px 16px;
            }
            .header h1 {
                font-size: 20px;
            }
            .button {
                display: block;
                text-align: center;
            }
            .alert-details ul {
                padding-left: 16px;
            }
        }
    </style>
</head>
<body style="margin:0; padding:20px 10px; background-color:#f3f4f6;">
    <div class="email-container">
        <div class="header">
            <h1>🚨 Emergency Alert</h1>
        </div>
        <div class="content">
            <h2 style="margin-top:0;">Dear {{ $station->name }},</h2>
            <p>A new emergency report has been assigned to your station.</p>
            <div class="alert-details">
                <strong>Report details:</strong>
                <ul>
                    <li><strong>Report ID:</strong> #{{ $report->id }}</li>
                    <li><strong>Type:</strong> {{ ucfirst($report->type) }}</li>
                    <li><strong>Location:</strong> {{ $report->location }}</li>
                    <li><strong>Description:</strong> {{ $report->description }}</li>
                </ul>
            </div>
            <p>Please respond as soon as possible. You can view the full report by clicking the button below.</p>
            <a href="{{ url('/admin/reports/'.$report->id) }}" class="button">View Report →</a>
            <p style="margin-top: 24px; font-size: 14px; color: #4b5563;">Thank you for your service.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Emergency Response System – Automated Alert<br>
            This is an urgent notification.
        </div>
    </div>
</body>
</html>
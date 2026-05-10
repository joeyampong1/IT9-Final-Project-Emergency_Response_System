<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Status Updated</title>
    <style>
        /* Basic reset & responsive */
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
        .status-badge {
            display: inline-block;
            background-color: #fef3c7;
            color: #b45309;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0 10px;
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
        }
    </style>
</head>
<body style="margin:0; padding:20px 10px; background-color:#f3f4f6;">
    <div class="email-container">
        <div class="header">
            <h1>Emergency Response System</h1>
        </div>
        <div class="content">
            <h2 style="margin-top:0; font-size:20px;">Hello {{ $report->reporter->name }},</h2>
            <p>Your emergency report <strong>#{{ $report->id }}</strong> has been updated.</p>
            <div class="status-badge">Current status: {{ ucfirst($report->status) }}</div>
            @if($report->responder)
                <p><strong>Assigned to:</strong> {{ $report->responder->name }}</p>
            @endif
            <p>You can view the full details and history by logging into your account:</p>
            <a href="{{ url('/reports/'.$report->id) }}" class="button">View your report →</a>
            <p style="margin-top: 24px; font-size: 14px; color: #4b5563;">Thank you for using the Emergency Response System.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Emergency Response System. All rights reserved.<br>
            This is an automated message, please do not reply.
        </div>
    </div>
</body>
</html>
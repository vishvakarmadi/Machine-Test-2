<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Property Enquiry</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f6f9;
            padding: 40px 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .email-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .email-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 40px 30px;
        }
        .property-badge {
            display: inline-block;
            background-color: #e8f0fe;
            color: #1a73e8;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 50px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e3c72;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #eef2f6;
            padding-bottom: 8px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .info-table th {
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #7f8c8d;
            padding: 10px 0;
            width: 30%;
            vertical-align: top;
        }
        .info-table td {
            font-size: 15px;
            color: #2c3e50;
            font-weight: 500;
            padding: 10px 0;
            vertical-align: top;
        }
        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #2a5298;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin-top: 15px;
            font-style: italic;
            color: #4a5568;
            line-height: 1.6;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #eef2f6;
        }
        .email-footer p {
            margin: 0;
            font-size: 12px;
            color: #95a5a6;
            line-height: 1.5;
        }
        .btn-view {
            display: inline-block;
            background-color: #2a5298;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>LuxeEstates</h1>
                <p>New Property Enquiry Notification</p>
            </div>
            
            <div class="email-body">
                <span class="property-badge">Lead Received</span>
                
                <h3 class="section-title">Property Details</h3>
                <table class="info-table">
                    <tr>
                        <th>Property</th>
                        <td><strong>{{ $property->title }}</strong> (ID: #{{ $property->id }})</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td style="color: #27ae60; font-weight: 700;">${{ number_format($property->price) }}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>{{ $property->city }}</td>
                    </tr>
                </table>

                <h3 class="section-title">Client Information</h3>
                <table class="info-table">
                    <tr>
                        <th>Name</th>
                        <td>{{ $enquiry->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{ $enquiry->email }}" style="color: #2a5298; text-decoration: none;">{{ $enquiry->email }}</a></td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $enquiry->mobile }}</td>
                    </tr>
                </table>

                <h3 class="section-title">Client Message</h3>
                <div class="message-box">
                    "{{ $enquiry->message }}"
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ url('/admin/properties') }}" class="btn-view">Manage Properties</a>
                </div>
            </div>
            
            <div class="email-footer">
                <p>This is an automated notification from LuxeEstates. Please do not reply directly to this email.</p>
                <p style="margin-top: 5px;">&copy; {{ date('Y') }} LuxeEstates Admin Panel. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>vZBW Training Request</h2>
<div>
    <p>Hello {{ $to->initials }},</p>

    <p>This is an automated message to inform you that your training session has been dropped.</p>

    <p>Training Position: {{ $cert }}</p>
    <p>Start: {{ $start }}</p>
    <p>End: {{ $end }}</p>

    <p>Your session will be automatically re-opened and you will be notified when another mentor or instructor accepts the session.</p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

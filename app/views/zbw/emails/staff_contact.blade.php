<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>vZBW Staff Contact</h2>
<div>
    <p>Hello, {{ $to->initials }}</p>
    <p>The following message was sent to you from the ZBW website staff contact:</p>
    <p>From: <a href="mailto:{{ $from }}">{{ $from }}</a></p>
    <p>Subject: {{ $subject }}</p>
    <p>Message:</p>
    <p>{{ $content }}</p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

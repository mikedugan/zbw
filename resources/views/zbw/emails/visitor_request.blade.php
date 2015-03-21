<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>vZBW Error Report</h2>
<div>
    <p>Hello {{ $to->initials }},</p>
    <p>The following controller has submitted a visitor request form through the website:</p>

    <p>First Name: {{ $firstname }}</p>
    <p>Last Name: {{ $lastname }}</p>
    <p>Email: {{ $email }}</p>
    <p>CID: {{ $cid }}</p>
    <p>Division: {{ $home }}</p>
    <p>Rating: {{ $rating }}</p>
    <p>Message:</p>
    <p>{{ $body }}</p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Training Request Accepted</h2>
<div>
    <p>Hello {{ $to->initials }},</p>

    <p>This is an automated message to inform you that your training session has been accepted.</p>

    <p>Mentor/Instructor: {{ $staff->initials }}</p>
    <p>Training Position: {{ $cert }}</p>
    <p>Start: {{ $start }}</p>
    <p>End: {{ $end }}</p>

    <p><i>It is ZBW policy that you be available on TeamSpeak for the duration of your training request.
            If you are unable to attend, please inform the above staff member as soon as possible.</i></p>

</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

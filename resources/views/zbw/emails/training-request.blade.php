<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>vZBW Training Request</h2>
<div>
    <p>Hey {{ $to->initials }},</p>
    <p>This is an email to notify you a controller has submitted a training request on the ZBW website.</p>
    <p><b>Controller</b>: {{ $user->initials }}</p>
    <p><b>Training Requested</b>: {{ \Zbw\Core\Helpers::readableCert($request->cert_id) }}</p>

    <p><b>Requested Start Time:</b> {{ $request->start->toDayDateTimeString() }}</p>
    <p><b>Requested End Time:</b> {{ $request->end->toDayDateTimeString() }}</p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

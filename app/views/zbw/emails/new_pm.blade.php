<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>New Private Message from {{ $pm->sender->initials }}</h2>
<div>
<p>{{ $user->initials }},</p>
<p>You have received the following private message on the ZBW website:</p>
<p><strong>From:</strong> {{ $pm->sender->initials }}</p>
<p><strong>Date:</strong> {{ $pm->created_at->toDayDateTimeString() }}</p>
<p><strong>Subject: </strong> {{ $pm->subject }}</p>
{{ $pm->content }}
<p>You can view the message here {{ HTML::linkRoute('messages/{mid}', 'here', [$pm->id]) }}</p>
<p>Reminder-- <b>Do not respond to this email.</b></p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

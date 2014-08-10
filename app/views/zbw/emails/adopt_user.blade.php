<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>{{ $subject }}</h2>
<div>
    <p>Hello {{ $student->first_name }},</p>
    <p>This is an email forwarded to you on the behalf of your personal training staff that will be working with you one-on-one until you start live training at ZBW.</p>
    <p>Here's some basic information about your mentor or instructor:</p>
    <p><b>Name: </b> {{ $staff->username }} {{ "($staff->initials)" }}</p>
    <p><b>Rating: </b> {{ $staff->rating->long }} / {{ Zbw\Base\Helpers::readableCert($staff->cert) }}</p>
    <p>In order to make your initial training easier, {{ $staff->first_name }} would like to meet with you on Teamspeak (see instructions in welcome email) to help you get set up and answer any
    questions you might have.</p>
    <p><b>Requested Meeting Time: </b> {{ \Carbon::createFromFormat('m-d-Y H:i:s', $date)->toDayDateTimeString() }}</p>
    <p>Below is the original message from {{ $staff->first_name }}</p>
    <hr/>
    <div>{{ $content }}</div>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

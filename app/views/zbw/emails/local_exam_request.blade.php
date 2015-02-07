<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>ZBW Exam Request</h2>
<div>
  <p>A student has requested a ZBW exam on the website.</p>
  <ul>
    <li>Student: {{ $student->first_name . ' ' . $student->last_name }} ({{ $student->initials }})</li>
    <li>CID: {{ $student->cid }}</li>
    <li>Current Cert: {{ Zbw\Core\Helpers::readableCert($student->cert) }}</li>
    <li>Current Rating: {{ $student->rating->long }}</li>
    <li>ZBW Exam Requested: {{ $cert['id'] == 0 ? 'SOP' : Zbw\Core\Helpers::readableCert($cert['id']) }}</li>
  </ul>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

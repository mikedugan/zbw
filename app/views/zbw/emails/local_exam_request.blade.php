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
    <li>Student: {{ $student->initials }}</li>
    <li>CID: {{ $student->cid }}</li>
    <li>Current Cert: {{ Zbw\Core\Helpers::readableCert($student->cert) }}</li>
    <li>Current Rating: {{ $student->rating->long }}</li>
    <li>Exam Requested: {{ Zbw\Core\Helpers::readableCert($student->cert +1) }}</li>
    <li><i>Note: 'Off Peak' references the advanced exam for a particular certification.</i></li>
  </ul>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

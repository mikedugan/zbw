<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2 style="text-align:center">Your Boston ARTCC Visitor Application</h2>
<div>
 <p>Dear {{ $visitor->first_name }},</p>
 <p>We regret to inform you that your application to be a visiting controller at Boston ARTCC has been denied.</p>
 <p>The following reason(s) were provided by our staff, please feel free to contact <a href="mailto:datm@bostonartcc.net">datm@bostonartcc.net</a> with any questions.</p>
 <h3>Reason For Denial</h3>
 <p>{{ $content }}</p>
 <p>If you circumstances or reasons outlined above change in the future, we welcome you to reapply!</p>
</div>
<p>Best Regards,</p>
<p>Boston John, ZBW Bot</p>
</body>
</html>

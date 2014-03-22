<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>vZBW New User</h2>
<div>
    <p>Dear {{ $user->first_name }},</p>
    <p>Welcome to ZBW! We would like to welcome you to one of the best ARTCCs
    around! This email contains your login information for the ZBW website and
     its services! Should you have a question, please don't hesitate to contact
     a staff member!</p>
</div>
<div>
    <p><b>Username:</b> {{ $user->username }}</p>
    <p><b>Password:</b> {{ $password }}</p>
    <p><b>Controller Initials:</b> {{ $user->initials }}</p>
    <p><b>Registered CID: </b> {{ $user->cid }}</p>
    <p>You may elect to login to the ZBW website using your CID or your controller
    initials.</p>
</div>
<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

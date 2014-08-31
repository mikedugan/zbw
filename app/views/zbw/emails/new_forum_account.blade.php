<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Welcome to ZBW</h2>
<div>
<p>Hello {{ $user->username }},</p>
<p>We've gone ahead and created you a forum account for <a href="{{Config::get('app.url').'/forum'}}">vZBW</a></p>
<p>You will be automagically logged in whenever you log in to the ZBW website, however you can login to the forum directly with the below credentials:</p>
<p><b>Username: </b><i>{{$user->username}}</i></p>
<p><b>Password: </b><i>{{$password}}</i></p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

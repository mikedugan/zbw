<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>vZBW Password Reset/h2>
		<div>
			To reset your password, complete this form: {{ url('password/reset', array($token)) }}.
		</div>
		<p>Best Regards,</p>
		<p>Boston John, vZBW Bot</p>
	</body>
</html>

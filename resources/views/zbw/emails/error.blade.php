<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>vZBW Error Report</h2>
<div>
    <p>This is an error reported submitted from the Boston ARTCC website</p>
    <p><b>Name:</b> {{ $name }} ( <a href="mailto:{{$email}}">{{$email}}</a> )</p>
    <p><b>Page: </b> {{ $page }}</p>

    <p><b>What The User Was Trying to Do:</b> {{ $action }}</p>

    <p><b>Error Description: </b> {{ $error }}</p>
</div>

<p>Best Regards,</p>
<p>Boston John, vZBW Bot</p>
</body>
</html>

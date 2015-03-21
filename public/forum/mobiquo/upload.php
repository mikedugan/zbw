<?php

error_reporting(E_ALL & ~E_NOTICE);
if(isset($_GET['checkAccess']))
{
    echo "yes";
	exit;
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	showTestScreen();
}
include './mobiquo.php';

function showTestScreen()
{
	echo "Attachment Upload Interface for Tapatalk Application<br>";
	echo "<br>
<a href=\"http://tapatalk.com/api.php\" target=\"_blank\">Tapatalk API for Universal Forum Access</a> | <a href=\"http://tapatalk.com/build.php\" target=\"_blank\">Build Your Own</a><br>
For more details, please visit <a href=\"http://tapatalk.com\" target=\"_blank\">http://tapatalk.com</a>";
	exit;
}
<?php
/******************************************************************************
* repair_settings.php                                                         *
*******************************************************************************
* SMF: Simple Machines Forum                                                  *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                *
* =========================================================================== *
* Software Version:           SMF 1.1                                         *
* Software by:                Simple Machines (http://www.simplemachines.org) *
* Copyright 2001-2005 by:     Lewis Media (http://www.lewismedia.com)         *
* Support, News, Updates at:  http://www.simplemachines.org                   *
*******************************************************************************
* This program is free software; you may redistribute it and/or modify it     *
* under the terms of the provided license as published by Lewis Media.        *
*                                                                             *
* This program is distributed in the hope that it is and will be useful,      *
* but WITHOUT ANY WARRANTIES; without even any implied warranty of            *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                        *
*                                                                             *
* See the "license.txt" file for details of the Simple Machines license.      *
* The latest version can always be found at http://www.simplemachines.org.    *
******************************************************************************/

// Initialize everything and load the language files.
initialize_inputs();

$txt['smf_repair_settings'] = 'Settings Repair Tool';
$txt['no_value'] = '<i style="font-weight: normal; color: red;">Value not found!</i>';
$txt['default_value'] = 'Recommended value';
$txt['save_settings'] = 'Save Settings';
$txt['not_writable'] = 'Settings.php cannot be written to by your webserver.  Please modify the permissions on this file to allow write access.';
$txt['recommend_blank'] = '<i>(blank)</i>';
$txt['database_settings_hidden'] = 'Some settings are not being shown because the MySQL connection information is incorrect.';

$txt['critical_settings'] = 'Critical Settings';
$txt['critical_settings_info'] = 'These are the settings most likely to be screwing up your board, but try the things below (especially the path and URL ones) if these don\'t help.  You can click on the recommendded value to use it.';
$txt['maintenance'] = 'Maintenance Mode';
$txt['maintenance0'] = 'Off (recommended)';
$txt['maintenance1'] = 'Enabled';
$txt['maintenance2'] = 'Unusable <em>(not recommended!)</em>';
$txt['language'] = 'Language File';
$txt['cookiename'] = 'Cookie Name';
$txt['queryless_urls'] = 'Queryless URLs';
$txt['queryless_urls0'] = 'Off (recommended)';
$txt['queryless_urls1'] = 'On';
$txt['enableCompressedOutput'] = 'Output Compression';
$txt['enableCompressedOutput0'] = 'Off (recommended if you have problems)';
$txt['enableCompressedOutput1'] = 'On (saves a lot of bandwidth)';
$txt['databaseSession_enable'] = 'Database driven sessions';
$txt['databaseSession_enable0'] = 'Off (not recommended)';
$txt['databaseSession_enable1'] = 'On (recommended)';

$txt['database_settings'] = 'MySQL Database Info';
$txt['database_settings_info'] = 'This is the server, username, password, and database for your MySQL server.';
$txt['db_server'] = 'MySQL server';
$txt['db_name'] = 'MySQL database name';
$txt['db_user'] = 'MySQL username';
$txt['db_passwd'] = 'MySQL password';
$txt['db_prefix'] = 'MySQL table prefix';
$txt['db_persist'] = 'MySQL connection type';
$txt['db_persist0'] = 'Standard (recommended)';
$txt['db_persist1'] = 'Persistent (might cause problems)';

$txt['path_url_settings'] = 'Paths &amp; URLs';
$txt['path_url_settings_info'] = 'These are the paths and URLs to your SMF installation, and can cause big problems when they are wrong.  Sorry, there are a lot of them.';
$txt['boardurl'] = 'Forum URL';
$txt['boarddir'] = 'Forum Directory';
$txt['sourcedir'] = 'Sources Directory';
$txt['attachmentUploadDir'] = 'Attachment Directory';
$txt['avatar_url'] = 'Avatar URL';
$txt['avatar_directory'] = 'Avatar Directory';
$txt['smileys_url'] = 'Smileys URL';
$txt['smileys_dir'] = 'Smileys Directory';
$txt['theme_url'] = 'Default Theme URL';
$txt['images_url'] = 'Default Theme Images URL';
$txt['theme_dir'] = 'Default Theme Directory';
if (isset($_POST['submit']))
	set_settings();

// Note that we're using the default URLs because we aren't even going to try to use Settings.php's settings.
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>', $txt['smf_repair_settings'], '</title>
		<script language="JavaScript" type="text/javascript" src="Themes/default/script.js"></script>
		<style type="text/css">
			body
			{
				font-family: Verdana, sans-serif;
				background-color: #D4D4D4;
				margin: 0;
			}
			body, td
			{
				font-size: 10pt;
			}
			div#header
			{
				background-color: white;
				padding: 22px 4% 12px 4%;
				font-family: Georgia, serif;
				font-size: xx-large;
				border-bottom: 1px solid black;
				height: 40px;
			}
			div#content
			{
				padding: 20px 30px;
			}
			div.error_message
			{
				border: 2px dashed red;
				background-color: #E1E1E1;
				margin: 1ex 4ex;
				padding: 1.5ex;
			}
			div.panel
			{
				border: 1px solid gray;
				background-color: #F0F0F0;
				margin: 1ex 0;
				padding: 1.2ex;
			}
			div.panel h2
			{
				margin: 0;
				margin-bottom: 0.5ex;
				padding-bottom: 3px;
				border-bottom: 1px dashed black;
				font-size: 14pt;
				font-weight: normal;
			}
			div.panel h3
			{
				margin: 0;
				margin-bottom: 2ex;
				font-size: 10pt;
				font-weight: normal;
			}
			form
			{
				margin: 0;
			}
			td.textbox
			{
				padding-top: 2px;
				font-weight: bold;
				white-space: nowrap;
				padding-right: 2ex;
			}
		</style>
	</head>
	<body>
		<div id="header">
			<a href="http://www.simplemachines.org/" target="_blank"><img src="Themes/default/images/smflogo.gif" style="width: 250px; float: right;" alt="Simple Machines" border="0" /></a>
			<div title="Zanarkand">', $txt['smf_repair_settings'], '</div>
		</div>
		<div id="content">';

show_settings();

echo '
		</div>
	</body>
</html>';

function initialize_inputs()
{
	// Turn off magic quotes runtime and enable error reporting.
	@set_magic_quotes_runtime(0);
	error_reporting(E_ALL);
	if (@ini_get('session.save_handler') == 'user')
		@ini_set('session.save_handler', 'files');
	@session_start();

	// Add slashes, as long as they aren't already being added.
	if (get_magic_quotes_gpc() == 0)
	{
		foreach ($_POST as $k => $v)
		{
			if (is_array($v))
				foreach ($v as $k2 => $v2)
					$_POST[$k][$k2] = addslashes($v2);
			else
				$_POST[$k] = addslashes($v);
		}
	}

	// This is really quite simple; if ?delete is on the URL, delete the installer...
	if (isset($_GET['delete']))
	{
		@unlink(__FILE__);

		// Now just redirect to a blank.gif...
		header('Location: http://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']) . dirname($_SERVER['PHP_SELF']) . '/Themes/default/images/blank.gif');
		exit;
	}
}

function show_settings()
{
	global $txt;

	// Check to make sure Settings.php exists!
	if (file_exists(dirname(__FILE__) . '/Settings.php'))
		$settingsArray = file(dirname(__FILE__) . '/Settings.php');
	else
		$settingsArray = array();

	if (count($settingsArray) == 1)
		$settingsArray = preg_split('~[\r\n]~', $settingsArray[0]);

	$settings = array();
	for ($i = 0, $n = count($settingsArray); $i < $n; $i++)
	{
		$settingsArray[$i] = rtrim($settingsArray[$i]);

		if (substr($settingsArray[$i], 0, 1) == '$')
		{
			preg_match('~^[$]([a-zA-Z_]+)\s*=\s*(["\'])?(.*?)(?:\\2)?;~', $settingsArray[$i], $match);
			if (isset($match[3]))
			{
				if ($match[3] == 'dirname(__FILE__)')
					$settings[$match[1]] = dirname(__FILE__);
				elseif ($match[3] == 'dirname(__FILE__) . \'/Sources\'')
					$settings[$match[1]] = dirname(__FILE__) . '/Sources';
				elseif ($match[3] == '$boarddir . \'/Sources\'')
					$settings[$match[1]] = $settings['boarddir'] . '/Sources';
				else
					$settings[$match[1]] = stripslashes($match[3]);
			}
		}
	}

	if (isset($settings['db_server']) && isset($settings['db_name']) && isset($settings['db_user']) && isset($settings['db_passwd']))
	{
		$attempt = @mysql_connect($settings['db_server'], $settings['db_user'], $settings['db_passwd']);
		if ($attempt != false)
			$attempt = @mysql_select_db($settings['db_name']);

		if ($attempt && isset($settings['db_prefix']))
		{
			$request = @mysql_query("
				SELECT DISTINCT variable, value
				FROM $settings[db_prefix]settings");
			while ($row = @mysql_fetch_row($request))
				$settings[$row[0]] = $row[1];
			@mysql_free_result($request);

			$request = @mysql_query("
				SELECT variable, value
				FROM $settings[db_prefix]themes
				WHERE ID_THEME = 1
					AND variable IN ('theme_dir', 'theme_url', 'images_url')
				LIMIT 3");
			while ($row = @mysql_fetch_row($request))
				$settings[$row[0]] = $row[1];
			@mysql_free_result($request);

			$show_db_settings = $request;
		}
	}
	else
		$show_db_settings = false;

	$known_settings = array(
		'critical_settings' => array(
			'maintenance' => array('flat', 'int', 2),
			'language' => array('flat', 'string', 'english'),
			'cookiename' => array('flat', 'string', 'SMFCookie11'),
			'queryless_urls' => array('db', 'int', 1),
			'enableCompressedOutput' => array('db', 'int', 1),
			'databaseSession_enable' => array('db', 'int', 1),
		),
		'database_settings' => array(
			'db_server' => array('flat', 'string', 'localhost'),
			'db_name' => array('flat', 'string'),
			'db_user' => array('flat', 'string'),
			'db_passwd' => array('flat', 'string'),
			'db_prefix' => array('flat', 'string'),
			'db_persist' => array('flat', 'int', 1),
		),
		'path_url_settings' => array(
			'boardurl' => array('flat', 'string'),
			'boarddir' => array('flat', 'string'),
			'sourcedir' => array('flat', 'string'),
			'attachmentUploadDir' => array('db', 'string'),
			'avatar_url' => array('db', 'string'),
			'avatar_directory' => array('db', 'string'),
			'smileys_url' => array('db', 'string'),
			'smileys_dir' => array('db', 'string'),
			'theme_url' => array('theme', 'string'),
			'images_url' => array('theme', 'string'),
			'theme_dir' => array('theme', 'string'),
		)
	);

	$host = empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] . (empty($_SERVER['SERVER_PORT']) || $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT']) : $_SERVER['HTTP_HOST'];
	$url = 'http://' . $host . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
	$known_settings['path_url_settings']['boardurl'][2] = $url;
	$known_settings['path_url_settings']['boarddir'][2] = dirname(__FILE__);

	if (file_exists(dirname(__FILE__) . '/Sources'))
		$known_settings['path_url_settings']['sourcedir'][2] = realpath(dirname(__FILE__) . '/Sources');

	if (file_exists(dirname(__FILE__) . '/attachments'))
		$known_settings['path_url_settings']['attachmentUploadDir'][2] = realpath(dirname(__FILE__) . '/attachments');

	if (file_exists(dirname(__FILE__) . '/avatars'))
	{
		$known_settings['path_url_settings']['avatar_url'][2] = $url . '/avatars';
		$known_settings['path_url_settings']['avatar_directory'][2] = realpath(dirname(__FILE__) . '/avatars');
	}

	if (file_exists(dirname(__FILE__) . '/Smileys'))
	{
		$known_settings['path_url_settings']['smileys_url'][2] = $url . '/Smileys';
		$known_settings['path_url_settings']['smileys_dir'][2] = realpath(dirname(__FILE__) . '/Smileys');
	}

	if (file_exists(dirname(__FILE__) . '/Themes/default'))
	{
		$known_settings['path_url_settings']['theme_url'][2] = $url . '/Themes/default';
		$known_settings['path_url_settings']['images_url'][2] = $url . '/Themes/default/images';
		$known_settings['path_url_settings']['theme_dir'][2] = realpath(dirname(__FILE__) . '/Themes/default');
	}

	if (isset($attempt) && $attempt)
	{
		$request = @mysql_query("
			SHOW TABLES LIKE '%log_topics'");
		if (@mysql_num_rows($request) == 1)
			list ($known_settings['database_settings']['db_prefix'][2]) = preg_replace('~log_topics$~', '', mysql_fetch_row($request));
		@mysql_free_result($request);
	}
	elseif (empty($show_db_settings))
	{
		echo '
			<div class="error_message" style="margin-bottom: 2ex;">
				', $txt['database_settings_hidden'], '
			</div>';
	}

	echo '
			<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
				// Get the inner HTML of an element.
				function getInnerHTML(element)
				{
					if (typeof(element.innerHTML) != "undefined")
						return element.innerHTML;
					else
					{
						var returnStr = "";
						for (var i = 0; i < element.childNodes.length; i++)
							returnStr += getOuterHTML(element.childNodes[i]);

						return returnStr;
					}
				}

				function getOuterHTML(node)
				{
					if (typeof(node.outerHTML) != "undefined")
						return node.outerHTML;

					var str = "";

					switch (node.nodeType)
					{
					// An element.
					case 1:
						str += "<" + node.nodeName;

						for (var i = 0; i < node.attributes.length; i++)
						{
							if (node.attributes[i].nodeValue != null)
								str += " " + node.attributes[i].nodeName + "=\"" + node.attributes[i].nodeValue + "\"";
						}

						if (node.childNodes.length == 0 && in_array(node.nodeName.toLowerCase(), ["hr", "input", "img", "link", "meta", "br"]))
							str += " />";
						else
							str += ">" + getInnerHTML(node) + "</" + node.nodeName + ">";
						break;

					// 2 is an attribute.

					// Just some text..
					case 3:
						str += node.nodeValue;
						break;

					// A CDATA section.
					case 4:
						str += "<![CDATA" + "[" + node.nodeValue + "]" + "]>";
						break;

					// Entity reference..
					case 5:
						str += "&" + node.nodeName + ";";
						break;

					// 6 is an actual entity, 7 is a PI.

					// Comment.
					case 8:
						str += "<!--" + node.nodeValue + "-->";
						break;
					}

					return str;
				}
			// ]]></script>

			<form action="', $_SERVER['PHP_SELF'], '" method="post">
				<div class="panel">';

	foreach ($known_settings as $settings_section => $section)
	{
		echo '
					<h2>', $txt[$settings_section], '</h2>
					<h3>', $txt[$settings_section . '_info'], '</h3>

					<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 3ex;">
						<tr>';

		foreach ($section as $setting => $info)
		{
			if ($info[0] != 'flat' && empty($show_db_settings))
				continue;

			echo '
							<td width="20%" valign="top" class="textbox" style="padding-bottom: 1ex;">
								<label for="', $setting, '">', $txt[$setting], ':</label>', !isset($settings[$setting]) && $info[1] != 'check' ? '<br />
								' . $txt['no_value'] : '', '
							</td>
							<td style="padding-bottom: 1ex;">';

			if ($info[1] == 'int' || $info[1] == 'check')
			{
				for ($i = 0; $i <= $info[2]; $i++)
					echo '
								<label for="', $setting, $i, '"><input type="radio" name="', $info[0], 'settings[', $setting, ']" id="', $setting, $i, '" value="', $i, '"', isset($settings[$setting]) && $settings[$setting] == $i ? ' checked="checked"' : '', ' class="check" /> ', $txt[$setting . $i], '</label><br />';
			}
			elseif ($info[1] == 'string')
			{
				echo '
								<input type="text" name="', $info[0], 'settings[', $setting, ']" id="', $setting, '" value="', isset($settings[$setting]) ? $settings[$setting] : '', '" size="', $settings_section == 'path_url_settings' ? '60" style="width: 80%;' : '30', '" />';

				if (isset($info[2]))
					echo '
								<div style="font-size: smaller;">', $txt['default_value'], ': &quot;<b><a href="javascript:void(0);" onclick="document.getElementById(\'', $setting, '\').value = ', $info[2] == '' ? '\'\';">' . $txt['recommend_blank'] : 'getInnerHTML(this);">' . $info[2], '</a></b>&quot;.</div>';
			}

			echo '
							</td>
						</tr><tr>';
		}

		echo '
							<td colspan="2"></td>
						</tr>
					</table>';
	}

	echo '

					<div align="right" style="margin: 1ex;">';

	$failure = false;
	if (substr(__FILE__, 1, 2) != ':\\')
	{
		// On linux, it's easy - just use is_writable!
		$failure |= !is_writable('Settings.php') && !@chmod('Settings.php', 0777);
	}
	// Windows is trickier.  Let's try opening for r+...
	else
	{
		// Funny enough, chmod actually does do something on windows - it removes the read only attribute.
		@chmod(dirname(__FILE__) . '/' . 'Settings.php', 0777);
		$fp = @fopen(dirname(__FILE__) . '/' . 'Settings.php', 'r+');

		// Hmm, okay, try just for write in that case...
		if (!$fp)
			$fp = @fopen(dirname(__FILE__) . '/' . 'Settings.php', 'w');

		$failure |= !$fp;
		@fclose($fp);
	}

	if ($failure)
		echo '
				<input type="submit" name="submit" value="', $txt['save_settings'], '" disabled="disabled" /><br />', $txt['not_writable'];
	else
		echo '
				<input type="submit" name="submit" value="', $txt['save_settings'], '" />';

	echo '
				</div>
				</div>
			</form>';
}

function set_settings()
{
	$db_updates = isset($_POST['dbsettings']) ? $_POST['dbsettings'] : array();
	$theme_updates = isset($_POST['themesettings']) ? $_POST['themesettings'] : array();
	$file_updates = isset($_POST['flatsettings']) ? $_POST['flatsettings'] : array();

	$db_updates['theme_guests'] = 1;

	$settingsArray = file(dirname(__FILE__) . '/Settings.php');
	$settings = array();
	for ($i = 0, $n = count($settingsArray); $i < $n; $i++)
	{
		$settingsArray[$i] = rtrim($settingsArray[$i]);

		// Remove the redirect...
		if ($settingsArray[$i] == 'if (file_exists(dirname(__FILE__) . \'/install.php\'))')
		{
			$settingsArray[$i] = '';
			$settingsArray[$i++] = '';
			$settingsArray[$i++] = '';
			continue;
		}

		if (substr($settingsArray[$i], 0, 1) == '$' && preg_match('~^[$]([a-zA-Z_]+)\s*=\s*(["\'])?(.*?)(?:\\2)?;~', $settingsArray[$i], $match) == 1)
			$settings[$match[1]] = stripslashes($match[3]);

		foreach ($file_updates as $var => $val)
			if (strncasecmp($settingsArray[$i], '$' . $var, 1 + strlen($var)) == 0)
			{
				$comment = strstr($settingsArray[$i], '#');
				$settingsArray[$i] = '$' . $var . ' = \'' . $val . '\';' . ($comment != '' ? "\t\t" . $comment : '');
			}
	}

	// Blank out the file - done to fix a oddity with some servers.
	$fp = @fopen(dirname(__FILE__) . '/Settings.php', 'w');
	@fclose($fp);

	$fp = fopen(dirname(__FILE__) . '/Settings.php', 'r+');
	$lines = count($settingsArray);
	for ($i = 0; $i < $lines - 1; $i++)
	{
		// Don't just write a bunch of blank lines.
		if ($settingsArray[$i] != '' || $settingsArray[$i - 1] != '')
			fwrite($fp, $settingsArray[$i] . "\n");
	}
	fwrite($fp, $settingsArray[$i]);
	fclose($fp);

	// Make sure it works.
	require(dirname(__FILE__) . '/Settings.php');

	// Attempt a connection.
	@mysql_connect($db_server, $db_user, $db_passwd);
	@mysql_select_db($db_name);

	$setString = '';
	foreach ($db_updates as $var => $val)
		$setString .= "
				('$var', '$val'),";

	if (!empty($setString))
		@mysql_query("
			REPLACE INTO {$db_prefix}settings
				(variable, value)
			VALUES" . substr($setString, 0, -1));

	$setString = '';
	foreach ($theme_updates as $var => $val)
		$setString .= "
				(1, 0, '$var', '$val'),";

	if (!empty($setString))
		@mysql_query("
			REPLACE INTO {$db_prefix}themes
				(ID_THEME, ID_MEMBER, variable, value)
			VALUES" . substr($setString, 0, -1));
}

?>
<?php

/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines http://www.simplemachines.org
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0
 */

########## Maintenance ##########
# Note: If $maintenance is set to 2, the forum will be unusable!  Change it to 0 to fix it.
$mtitle = 'Migration in Progress!';		# Title for the Maintenance Mode message.
$mmessage = 'ZBW Forum will be back online by 0500Z';		# Description of why the forum is in maintenance mode.

########## Forum Info ##########
$mbname = 'Boston ARTCC';		# The name of your forum.
$language = 'english';		# The default language file set for the forum.
$boardurl = 'http://bostonartcc.net/forum';		# URL to your forum's folder. (without the trailing /!)
$webmaster_email = 'admin@bostonartcc.net';		# Email address to send emails from. (like noreply@yourdomain.com.)
$cookiename = 'SMFCookie391';		# Name of the cookie to set for authentication.

########## Database Info ##########
$db_type = 'mysql';
$db_server = 'localhost';
$db_name = 'zbw_forum';
$db_user = 'mike';
$db_passwd = 'Mickeyd2!';
$ssi_db_user = '';
$ssi_db_passwd = '';
$db_prefix = 'smf_';
$db_persist = 0;
$db_error_send = 0;

########## Directories/Files ##########
# Note: These directories do not have to be changed unless you move things.
$base = "/var/www/vhosts/bostonartcc.net/public/forum";
$boarddir = $base;		# The absolute path to the forum's folder. (not just '.'!)
$sourcedir = $base.'/Sources';		# Path to the Sources directory.
$cachedir = $base.'cache';		# Path to the cache directory.

########## Error-Catching ##########
# Note: You shouldn't touch these settings.
$db_last_error = 0;

# Make sure the paths are correct... at least try to fix them.
if (!file_exists($boarddir) && file_exists(dirname(__FILE__) . '/agreement.txt'))
	$boarddir = dirname(__FILE__);
if (!file_exists($sourcedir) && file_exists($boarddir . '/Sources'))
	$sourcedir = $boarddir . '/Sources';
if (!file_exists($cachedir) && file_exists($boarddir . '/cache'))
	$cachedir = $boarddir . '/cache';

$maintenance = 0;
?>

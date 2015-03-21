<?php
define('SMF', 1);
define('IN_MOBIQUO', true);
error_reporting(0);
$forum_version = 'SMF 2.0';

// This makes it so headers can be sent!
ob_start();

// Do some cleaning, just in case.
foreach (array('db_character_set', 'cachedir') as $variable)
    if (isset($GLOBALS[$variable]))
        unset($GLOBALS[$variable]);

// Load the settings...
require_once(dirname(dirname(__FILE__)) . '/Settings.php');

// Make absolutely sure the cache directory is defined.
if ((empty($cachedir) || !file_exists($cachedir)) && file_exists($boarddir . '/cache'))
    $cachedir = $boarddir . '/cache';

// And important includes.
require_once($sourcedir . '/QueryString.php');
require_once('include/Subs.php');
require_once('include/error_control.php');
require_once('include/Load.php');
require($sourcedir . '/Security.php');

// Using an pre-PHP5 version?
if (@version_compare(PHP_VERSION, '5') == -1)
    require_once($sourcedir . '/Subs-Compat.php');

// If $maintenance is set specifically to 2, then we're upgrading or something.
if (!empty($maintenance) && $maintenance == 2)
    db_fatal_error();
    
// Create a variable to store some SMF specific functions in.
$smcFunc = array();

// Initate the database connection and define some database functions to use.
loadDatabase();

// Load the settings from the settings table, and perform operations like optimizing.
reloadSettings();
$_SERVER['QUERY_STRING'] = '';

// Clean the request variables, add slashes, etc.
cleanRequest();
$context = array();

// Seed the random generator.
if (empty($modSettings['rand_seed']) || mt_rand(1, 250) == 69)
    smf_seed_generator();

// Before we get carried away, are we doing a scheduled task? If so save CPU cycles by jumping out!
if (isset($_GET['scheduled']))
{
    require_once($sourcedir . '/ScheduledTasks.php');
    AutoTask();
}


// Register an error handler.
set_error_handler('error_handler');


// Start the session. (assuming it hasn't already been.)
loadSession();


$sc = $_SESSION['session_value'];
$_GET[$_SESSION['session_var']] = $_SESSION['session_value'];
$_POST[$_SESSION['session_var']] = $_SESSION['session_value'];

define('WIRELESS', false);

if (isset($_GET['user_id']))
{
    $user = loadMemberData(intval($_GET['user_id']), false, 'profile'); 
}
elseif (isset($_GET['username']))
{
    $user = loadMemberData(base64_decode($_GET['username']), true, 'profile');
    if (empty($user))
    {
        $user = loadMemberData($_GET['username'], true, 'profile');
    }
}
else
{
    exit;
}

$url = '';
if(isset($user[0]) && !empty($user[0]))
{
    if(empty($url))
    {
        $memID = $user[0];
        $context['id_member'] = $user[0];
        $GLOBALS['cur_profile'] = $GLOBALS['user_profile'][$memID];
        loadMemberContext($memID);
        if(isset($GLOBALS['memberContext'][$memID]['avatar']['href']))
        {
            $url = $GLOBALS['memberContext'][$memID]['avatar']['href'];
            header("Location: $url", 0, 303);
        }
    }
}
ob_end_clean();


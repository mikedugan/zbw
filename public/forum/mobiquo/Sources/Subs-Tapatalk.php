<?php

if (!defined('SMF'))
    die('Hacking attempt...');

//Admin Areas
function Tapatalk_add_admin_areas(&$adminAreas)
{
    global $txt;
    $adminAreas['config']['areas'] += array(
        'tapatalksettings' => array(
            'label' => $txt['tapatalktitle'],
            'file' => 'ManageTapatalk.php',
            'function' => 'ManageTapatalk',
            'icon' => 'tapatalk_settings.png',
            'subsections' => array(
                'general' => array($txt['tp_general_settings']),
                'boards' => array($txt['tp_board_settings']),
                'iar' => array($txt['tp_iar_settings']),
                'rebranding' => array($txt['tp_rebranding_settings']),
                'others' => array($txt['tp_other_settings']),
            ),
        ),
    );
}

//get ip
function exttMbqGetIP()
{
    $realip = '';
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $realip = getenv( "HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}

//judge is spam user
function exttmbq_is_spam($email, $ip='')
{
    $ori_email = $email;
    $ori_ip = $ip;
    if($email || $ip)
    {
        $params = '';
        if($email)

        {
            $params = "&email=".urlencode($email);
        }

        if($ip)
        {
            $params .= "&ip=".urlencode($ip);
        }
        
        $ctx = stream_context_create(array( 'http' => array( 'timeout' => 3 ) ) );
        $resp = @file_get_contents("http://www.stopforumspam.com/api?f=serial".$params, 0, $ctx);
        $resp = unserialize($resp);

        if ((isset($resp['email']['confidence']) && $resp['email']['confidence'] > 50) ||
            (isset($resp['ip']['confidence']) && $resp['ip']['confidence'] > 60))
        {
            return true;
        }
    }
    
    return false;
}

?>
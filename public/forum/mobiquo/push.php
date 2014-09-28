<?php

define('IN_MOBIQUO', 1);

if(isset($_GET['allowAccess']))
{
    echo "yes";
    exit;
}

if (isset($_GET['checkip']))
{
    print do_post_request(array('ip' => 1) , true);
}
else
{
    $output = 'Tapatalk Push Notification Status Monitor<br><br>';
    $output .= 'Push notification test: <b>';
    require_once(dirname(dirname(__FILE__)) . '/SSI.php');
    global $modSettings, $smcFunc;
    if(isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']))
    {
        $push_key = $modSettings['tp_push_key'];
        $return_status = do_post_request(array('test' => 1, 'key' => $push_key), true);
        if ($return_status === '1')
            $output .= 'Success</b>';
        else
            $output .= 'Failed</b><br />'.$return_status;
    }
    else
    {
        $output .= 'Failed</b><br />Please set Tapatalk API Key at forum option/setting<br />';
    }
    
    $ip =  do_post_request(array('ip' => 1), true);
    $forum_url =  get_forum_path();

    $table_exist = mobi_table_exist('tapatalk_users') ?'Yes' : 'No';

    $output .="<br>Current forum url: ".$forum_url."<br>";
    $output .="Current server IP: ".$ip."<br>";
    $output .="Tapatalk user table existence:".$table_exist."<br>";
    if(isset($modSettings['push_slug']))
    {
        $push_slug = unserialize(base64_decode($modSettings['push_slug']));
        if(!empty($push_slug) && is_array($push_slug))
            $output .= 'Push Slug Status : ' . ($push_slug['stick'] == 1 ? 'Stick' : 'Free') . '<br />';
        if(isset($_GET['slug']))
            $output .= 'Push Slug Value: ' . $modSettings['push_slug'] . "<br /><br />";
    }
    $output .="<br>
<a href=\"http://tapatalk.com/api.php\" target=\"_blank\">Tapatalk API for Universal Forum Access</a> | <a href=\"http://tapatalk.com/build.php\" target=\"_blank\">Build Your Own</a><br>
For more details, please visit <a href=\"http://tapatalk.com\" target=\"_blank\">http://tapatalk.com</a>";
    echo $output;
}

function do_post_request($data, $pushTest = false)
{
    $push_url = 'http://push.tapatalk.com/push.php';
    $response = getPushContentFromRemoteServer($push_url, $pushTest ? 10 : 0, $error, 'POST', $data);
    return $response;
}


/**
 * Get content from remote server
 *
 * @param string $url      NOT NULL          the url of remote server, if the method is GET, the full url should include parameters; if the method is POST, the file direcotry should be given.
 * @param string $holdTime [default 0]       the hold time for the request, if holdtime is 0, the request would be sent and despite response.
 * @param string $error_msg                  return error message
 * @param string $method   [default GET]     the method of request.
 * @param string $data     [default array()] post data when method is POST.
 *
 * @exmaple: getContentFromRemoteServer('http://push.tapatalk.com/push.php', 0, $error_msg, 'POST', $ttp_post_data)
 * @return string when get content successfully|false when the parameter is invalid or connection failed.
*/
function getPushContentFromRemoteServer($url, $holdTime = 0, &$error_msg, $method = 'GET', $data = array())
{
    //Validate input.
    $vurl = parse_url($url);
    if ($vurl['scheme'] != 'http')
    {
        $error_msg = 'Error: invalid url given: '.$url;
        return false;
    }
    if($method != 'GET' && $method != 'POST')
    {
        $error_msg = 'Error: invalid method: '.$method;
        return false;//Only POST/GET supported.
    }
    if($method == 'POST' && empty($data))
    {
        $error_msg = 'Error: data could not be empty when method is POST';
        return false;//POST info not enough.
    }

    if(!empty($holdTime) && function_exists('file_get_contents') && $method == 'GET')
    {
        $response = @file_get_contents($url);
    }
    else if (@ini_get('allow_url_fopen'))
    {
        if(empty($holdTime))
        {
            // extract host and path:
            $host = $vurl['host'];
            $path = $vurl['path'];

            if($method == 'POST')
            {
                $fp = @fsockopen($host, 80, $errno, $errstr, 5);

                if(!$fp)
                {
                    $error_msg = 'Error: socket open time out or cannot connet.';
                    return false;
                }

                $data =  http_build_query($data);

                fputs($fp, "POST $path HTTP/1.1\r\n");
                fputs($fp, "Host: $host\r\n");
                fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
                fputs($fp, "Content-length: ". strlen($data) ."\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                fputs($fp, $data);
                fclose($fp);
            }
            else
            {
                $error_msg = 'Error: 0 hold time for get method not supported.';
                return false;
            }
        }
        else
        {
            if($method == 'POST')
            {
                $params = array('http' => array(
                    'method' => 'POST',
                    'content' => http_build_query($data, '', '&'),
                ));
                $ctx = stream_context_create($params);
                $old = ini_set('default_socket_timeout', $holdTime);
                $fp = @fopen($url, 'rb', false, $ctx);
            }
            else
            {
                $fp = @fopen($url, 'rb', false);
            }
            if (!$fp)
            {
                $error_msg = 'Error: fopen failed.';
                return false;
            }
            ini_set('default_socket_timeout', $old);
            stream_set_timeout($fp, $holdTime);
            stream_set_blocking($fp, 0);

            $response = @stream_get_contents($fp);
        }
    }
    elseif (function_exists('curl_init'))
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if($method == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if(empty($holdTime))
        {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT,1);
        }
        $response = curl_exec($ch);
        curl_close($ch);
    }
    else
    {
        $error_msg = 'CURL is disabled and PHP option "allow_url_fopen" is OFF. You can enable CURL or turn on "allow_url_fopen" in php.ini to fix this problem.';
        return false;
    }
    return $response;
}

function mobi_table_exist($table_name)
{
    global $smcFunc, $db_prefix, $db_name;
    $tb_prefix = preg_replace('/`'.$db_name.'`./', '', $db_prefix);
    db_extend();
    $tables = $smcFunc['db_list_tables'](false, $tb_prefix . "tapatalk_users");
    return !empty($tables);
}

function get_forum_path()
{
    $path =  '../';

    if (!empty($_SERVER['SCRIPT_NAME']) && !empty($_SERVER['HTTP_HOST']))
    {
        $path = $_SERVER['HTTP_HOST'];
        $path .= dirname(dirname($_SERVER['SCRIPT_NAME']));
    }
    return $path;
}

if (!function_exists('http_build_query')) {

    function http_build_query($data, $prefix = null, $sep = '', $key = '')
    {
        $ret = array();
        foreach ((array )$data as $k => $v) {
            $k = urlencode($k);
            if (is_int($k) && $prefix != null) {
                $k = $prefix . $k;
            }
 
            if (!empty($key)) {
                $k = $key . "[" . $k . "]";
            }
 
            if (is_array($v) || is_object($v)) {
                array_push($ret, http_build_query($v, "", $sep, $k));
            } else {
                array_push($ret, $k . "=" . urlencode($v));
            }
        }
 
        if (empty($sep)) {
            $sep = ini_get("arg_separator.output");
        }
 
        return implode($sep, $ret);
    }
}
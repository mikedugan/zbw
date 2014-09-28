<?php

if (!defined('SMF'))
    die('Hacking attempt...');

error_reporting(0);

function tapatalk_push_reply($post_id)
{
    global $user_info, $context, $smcFunc, $boardurl, $modSettings;

    //subscribe push
    $pushed_user_ids = array();
    if ($context['current_topic'] && $post_id && (function_exists('curl_init') || ini_get('allow_url_fopen')))
    {
        $request = $smcFunc['db_query']('', '
            SELECT ts.id_member
            FROM {db_prefix}log_notify ts
            LEFT JOIN {db_prefix}tapatalk_users tu ON (ts.id_member=tu.userid)
            WHERE ts.id_topic = {int:topic_id}',
            array(
                'topic_id' => $context['current_topic'],
            )
        );
        while($row = $smcFunc['db_fetch_assoc']($request))
        {
            if ($row['id_member'] == $user_info['id']) continue;
    
            $ttp_data = array(
                'userid'    => $row['id_member'],
                'type'      => 'sub',
                'id'        => $context['current_topic'],
                'subid'     => $post_id,
                'title'     => tt_push_clean($_POST['subject']),
                'author'    => tt_push_clean($user_info['name']),
                'dateline'  => time(),
            );
            $pushed_user_ids[] = $row['id_member'];
            store_as_alert($ttp_data);
            $ttp_post_data = array(
                'url'  => $boardurl,
                'data' => base64_encode(serialize(array($ttp_data))),
            );
            if(isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']))
                $ttp_post_data['key'] = $modSettings['tp_push_key'];
            $return_status = tt_do_post_request($ttp_post_data);
        }
    }
    tapatalk_push_quote_tag($post_id, false, $pushed_user_ids);
}

function tapatalk_push_quote_tag($post_id, $newtopic = false, $pushed_user_ids = array())
{
    global $user_info, $context, $smcFunc, $boardurl, $modSettings, $topic;
    
    if (($newtopic ? $topic : $context['current_topic']) && isset($_POST['message']) && $post_id && (function_exists('curl_init') || ini_get('allow_url_fopen')))
    {
        $message = $_POST['message'];
        //quote push
        $quotedUsers = array();
        if(preg_match_all('/\[quote author=(.*?) link=.*?\]/si', $message, $quote_matches))
        {
            $quotedUsers = $quote_matches[1];
            $quote_ids = verify_smf_userids_from_names($quotedUsers);
            if(!empty($quote_ids))
            {
                $request = $smcFunc['db_query']('', '
                    SELECT tu.userid
                    FROM {db_prefix}tapatalk_users tu
                    WHERE tu.userid IN ({'.(is_array($quote_ids) ? 'array_int': 'int').':quoteids})' ,
                    array(
                        'quoteids' => $quote_ids,
                    )
                );
                while($row = $smcFunc['db_fetch_assoc']($request))
                {
                    if ($row['userid'] == $user_info['id']) continue;
                    if (in_array($row['userid'], $pushed_user_ids)) continue;
                    
                    $ttp_data = array(
                        'userid'    => $row['userid'],
                        'type'      => 'quote',
                        'id'        => ($newtopic ? $topic : $context['current_topic']),
                        'subid'     => $post_id,
                        'title'     => tt_push_clean($_POST['subject']),
                        'author'    => tt_push_clean($user_info['name']),
                        'dateline'  => time(),
                    );
                    $pushed_user_ids[] = $row['userid'];
                    store_as_alert($ttp_data);
                    $ttp_post_data = array(
                        'url'  => $boardurl,
                        'data' => base64_encode(serialize(array($ttp_data))),
                    );
                    if(isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']))
                        $ttp_post_data['key'] = $modSettings['tp_push_key'];
                    $return_status = tt_do_post_request($ttp_post_data);
                }
            }
        }
        //@ push
        if (preg_match_all( '/(?<=^@|\s@)(#(.{1,50})#|\S{1,50}(?=[,\.;!\?]|\s|$))/U', $message, $tags ) )
        {
            foreach ($tags[2] as $index => $tag)
            {
                if ($tag) $tags[1][$index] = $tag;
            }
            $tagged_usernames =  array_unique($tags[1]);
            $tag_ids = verify_smf_userids_from_names($tagged_usernames);
            if(!empty($tag_ids))
            {
                $request = $smcFunc['db_query']('', '
                    SELECT tu.userid
                    FROM {db_prefix}tapatalk_users tu
                    WHERE tu.userid IN ({array_int:tag_ids})' ,
                    array(
                        'tag_ids' => $tag_ids,
                    )
                );
                while($row = $smcFunc['db_fetch_assoc']($request))
                {
                    if ($row['userid'] == $user_info['id']) continue;
                    if (in_array($row['userid'], $pushed_user_ids)) continue;
                    
                    $ttp_data = array(
                        'userid'    => $row['userid'],
                        'type'      => 'tag',
                        'id'        => ($newtopic ? $topic : $context['current_topic']),
                        'subid'     => $post_id,
                        'title'     => tt_push_clean($_POST['subject']),
                        'author'    => tt_push_clean($user_info['name']),
                        'dateline'  => time(),
                    );
                    $pushed_user_ids[] = $row['userid'];
                    store_as_alert($ttp_data);
                    $ttp_post_data = array(
                        'url'  => $boardurl,
                        'data' => base64_encode(serialize(array($ttp_data))),
                    );
                    if(isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']))
                        $ttp_post_data['key'] = $modSettings['tp_push_key'];
                    $return_status = tt_do_post_request($ttp_post_data);
                }
            }
        }
    }
}

function tapatalk_push_pm()
{
    global $user_info, $smcFunc, $boardurl, $modSettings, $context;

    $sent_recipients = !empty($context['send_log']) && !empty($context['send_log']['sent']) ? array_keys($context['send_log']['sent']) : array();

    if (isset($sent_recipients) && !empty($sent_recipients) && isset($_POST['subject']))
    {
        $timestr = time();
        $id_pm_req = $smcFunc['db_query']('', '
            SELECT p.id_pm
            FROM {db_prefix}personal_messages p
            WHERE p.msgtime > {int:msgtime_l} AND p.msgtime < {int:msgtime_h} AND p.id_member_from = {int:send_userid} ',
            array(
                'msgtime_l' => $timestr-10,
                'msgtime_h' => $timestr+10,
                'send_userid' => $user_info['id'],
            ));
        $id_pm = $smcFunc['db_fetch_assoc']($id_pm_req);

        if($id_pm_req)
            $smcFunc['db_free_result']($id_pm_req);

        if ($id_pm)
        {
            $request = $smcFunc['db_query']('', '
                SELECT tu.userid
                FROM {db_prefix}tapatalk_users tu
                WHERE tu.userid IN ({array_int:recipient_to})',
                array(
                    'recipient_to' => $sent_recipients,//$recipientList['to'],
                )
            );
            while($row = $smcFunc['db_fetch_assoc']($request))
            {
                if ($row['userid'] == $user_info['id']) continue;
                
                $ttp_data = array(
                    'userid'    => $row['userid'],
                    'type'      => 'pm',
                    'id'        => $id_pm['id_pm'],
                    'title'     => tt_push_clean($_POST['subject']),
                    'author'    => tt_push_clean($user_info['name']),
                    'dateline'  => time(),
                );
                store_as_alert($ttp_data);
                $ttp_post_data = array(
                    'url'  => $boardurl,
                    'data' => base64_encode(serialize(array($ttp_data))),
                );
                if(isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']))
                    $ttp_post_data['key'] = $modSettings['tp_push_key'];
                tt_do_post_request($ttp_post_data);
            }
        }
    }
}

function tt_do_post_request($data)
{
    global $boardurl, $modSettings;
    $push_url = 'http://push.tapatalk.com/push.php';

    if(!function_exists('updateSettings'))
        require_once($sourcedir . '/Subs.php');

    //Initial this key in modSettings
    if(!isset($modSettings['push_slug']))
        updateSettings(array('push_slug' => 0));

    //Get push_slug from db
    $push_slug = isset($modSettings['push_slug'])? $modSettings['push_slug'] : 0;
    $slug = base64_decode($push_slug);
    $slug = push_slug($slug, 'CHECK');
    $check_res = unserialize($slug);

    //If it is valide(result = true) and it is not sticked, we try to send push
    if($check_res['result'] && !$check_res['stick'])
    {
        //Slug is initialed or just be cleared
        if($check_res['save'])
        {
            updateSettings(array('push_slug' => base64_encode($slug)));
        }

        //Send push
        $push_resp = getPushContentFromRemoteServer($push_url, 0, $error, 'POST', $data);
        if(trim($push_resp) === 'Invalid push notification key') $push_resp = 1;
        if(!is_numeric($push_resp))
        {
            //Sending push failed, try to update push_slug to db
            $slug = push_slug($slug, 'UPDATE');
            $update_res = unserialize($slug);
            if($update_res['result'] && $update_res['save'])
            {
                updateSettings(array('push_slug' => base64_encode($slug)));
            }
        }
    }
}

function push_slug($push_v, $method = 'NEW')
{
    if(empty($push_v))
        $push_v = serialize(array());
    $push_v_data = unserialize($push_v);
    $current_time = time();
    if(!is_array($push_v_data))
        return serialize(array('result' => 0, 'result_text' => 'Invalid v data', 'stick' => 0));
    if($method != 'CHECK' && $method != 'UPDATE' && $method != 'NEW')
        return serialize(array('result' => 0, 'result_text' => 'Invalid method', 'stick' => 0));

    if($method != 'NEW' && !empty($push_v_data))
    {
        $push_v_data['save'] = $method == 'UPDATE';
        if($push_v_data['stick'] == 1)
        {
            if($push_v_data['stick_timestamp'] + $push_v_data['stick_time'] > $current_time)
                return $push_v;
            else
                $method = 'NEW';
        }
    }

    if($method == 'NEW' || empty($push_v_data))
    {
        $push_v_data = array();                       //Slug
        $push_v_data['max_times'] = 3;                //max push failed attempt times in period
        $push_v_data['max_times_in_period'] = 300;      //the limitation period
        $push_v_data['result'] = 1;                   //indicate if the output is valid of not
        $push_v_data['result_text'] = '';             //invalid reason
        $push_v_data['stick_time_queue'] = array();   //failed attempt timestamps
        $push_v_data['stick'] = 0;                    //indicate if push attempt is allowed
        $push_v_data['stick_timestamp'] = 0;          //when did push be sticked
        $push_v_data['stick_time'] = 600;             //how long will it be sticked
        $push_v_data['save'] = 1;                     //indicate if you need to save the slug into db
        return serialize($push_v_data);
    }

    if($method == 'UPDATE')
    {
        $push_v_data['stick_time_queue'][] = $current_time;
    }
    $sizeof_queue = count($push_v_data['stick_time_queue']);
    
    $period_queue = $sizeof_queue > 1 && isset($push_v_data['stick_time_queue'][$sizeof_queue - 1]) && isset($push_v_data['stick_time_queue'][0]) ? ($push_v_data['stick_time_queue'][$sizeof_queue - 1] - $push_v_data['stick_time_queue'][0]) : 0;

    $times_overflow = $sizeof_queue > $push_v_data['max_times'];
    $period_overflow = $period_queue > $push_v_data['max_times_in_period'];

    if($period_overflow)
    {
        if(!array_shift($push_v_data['stick_time_queue']))
            $push_v_data['stick_time_queue'] = array();
    }
    
    if($times_overflow && !$period_overflow)
    {
        $push_v_data['stick'] = 1;
        $push_v_data['stick_timestamp'] = $current_time;
    }

    return serialize($push_v_data);
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
                return 1;
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

function tt_push_clean($str)
{
    $str = strip_tags($str);
    $str = trim($str);
    return html_entity_decode($str, ENT_QUOTES, 'UTF-8');
}

function store_as_alert($push_data)
{
	global $smcFunc, $db_prefix, $modSettings;
    db_extend();

    $matched_tables = $smcFunc['db_list_tables'](false, $db_prefix . "tapatalk_push");
    if(!empty($matched_tables))
	{
		$push_data['title'] = $smcFunc['db_escape_string']($push_data['title']);
		$push_data['author'] = $smcFunc['db_escape_string']($push_data['author']);
		$request = $smcFunc['db_insert']('ignore',
					'{db_prefix}tapatalk_push',
					array('userid' => 'int', 'type' => 'string', 'id' => 'int', 'subid' => 'int', 'title' => 'string', 'author' => 'string', 'dateline' => 'int'),
					array($push_data['userid'], $push_data['type'], $push_data['id'], isset($push_data['subid'])? $push_data['subid'] : 0, $push_data['title'], $push_data['author'], $push_data['dateline']),
					array('userid')
		);
		$affected_rows = $smcFunc['db_affected_rows']($request);
	}
	$current_time = time();
	// Check outdated push data and clean
	if(isset($modSettings['tp_alert_clean_time']) && !empty($modSettings['tp_alert_clean_time']))
	{
		$last_clean_time = $modSettings['tp_alert_clean_time'];
		$clean_period = 1*24*60*60;
		if($current_time - $last_clean_time > $clean_period)
		{
			$d_request = $smcFunc['db_query']('', '
				DELETE
				FROM {db_prefix}tapatalk_push
					WHERE dateline < {int:outdateTime}',
				array(
					'outdateTime' => $current_time - 30*24*60*60
				)
			);
			updateSettings(array('tp_alert_clean_time' => $current_time),true);
		}
	}
	else
	{
		updateSettings(array('tp_alert_clean_time' => $current_time));
	}
}

function verify_smf_userids_from_names($names)
{
    $direct_ids = array();
    $valid_names = array();
    $verified_ids = array();
    foreach($names as $index => $user)
    {
        if(is_numeric($user) && $user == intval($user))
            $direct_ids[] = $user;
        else
            $valid_names[] = $user;
    }
    if(!empty($valid_names))
    {
        $loaded_ids = loadMemberData($valid_names, true);
        //make sure tids only contains integer values
        if(is_array($loaded_ids))
        {
            foreach($loaded_ids as $idx => $loaded_id)
                if(is_numeric($loaded_id) && $loaded_id == intval($loaded_id))
                    $verified_ids[] = $loaded_id;
        }
        else
            if(is_numeric($loaded_ids) && $loaded_ids == intval($loaded_ids))
                    $verified_ids[] = $loaded_ids;
    }
    $verified_ids = array_unique(array_merge($direct_ids, $verified_ids));
    return $verified_ids;
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
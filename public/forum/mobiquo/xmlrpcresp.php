<?php

defined('IN_MOBIQUO') or exit;

function get_config_func()
{
    global $mobiquo_config, $user_info, $modSettings, $maintenance, $mmessage;
    
    exttMbqMakeFlags();

    $config_list = array(
        'is_open'    => new xmlrpcval( ($maintenance == 0) ? true : false, 'boolean'),
        'guest_okay' => new xmlrpcval($modSettings['allow_guestAccess']? true : false, 'boolean'),
        'push'       => new xmlrpcval('1','string'),
        'reg_url'       => new xmlrpcval($modSettings['tp_iar_registration_url'],'string'),
        'result_text'=> new xmlrpcval($maintenance == 1 ? $mmessage : '' , 'base64'),
        'sign_in' => new xmlrpcval(ExttMbqBase::$otherParameters['exttMbqSignIn'],'string'),
        'inappreg' => new xmlrpcval(ExttMbqBase::$otherParameters['exttMbqInappreg'],'string'),
        'sso_login' => new xmlrpcval(ExttMbqBase::$otherParameters['exttMbqSsoLogin'],'string'),
        'sso_signin' => new xmlrpcval(ExttMbqBase::$otherParameters['exttMbqSsoSignin'],'string'),
        'sso_register' => new xmlrpcval(ExttMbqBase::$otherParameters['exttMbqSsoRegister'],'string'),
        'native_register' => new xmlrpcval(ExttMbqBase::$otherParameters['exttMbqNativeRegister'],'string'),
    );
    if(allowedTo('search_posts'))
        $config_list['guest_search'] = new xmlrpcval('1', 'string');
    if(allowedTo('who_view'))
        $config_list['guest_whosonline'] = new xmlrpcval('1', 'string');
    foreach($mobiquo_config as $key => $value)
    {
        if (!in_array($key, array('is_open', 'guest_okay', 'mod_function', 'conflict_mod', 'push')))
        {
            $config_list[$key] = new xmlrpcval($value, 'string');
        }
    }
    if ($user_info['is_guest'] && allowedTo('search_posts'))
        $config_list['guest_search'] = new xmlrpcval('1', 'string');

    if ($user_info['is_guest'] && allowedTo('who_view'))
        $config_list['guest_whosonline'] = new xmlrpcval('1', 'string');
    if(isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']))
        $config_list['api_key'] = new xmlrpcval(md5($modSettings['tp_push_key']), 'string');

    action_get_board_stat();
    
    $stats = array(
        'user' => new xmlrpcval($modSettings['totalMembers'], 'int'),
        'topic' => new xmlrpcval($modSettings['totalTopics'], 'int'),
        'post'   => new xmlrpcval($modSettings['totalMessages'], 'int')
    );
    $config_list['stats'] = new xmlrpcval($stats, 'struct');

    $response = new xmlrpcval($config_list, 'struct');

    return new xmlrpcresp($response);
}

function get_forum_func()
{
    global $context;

    $response = new xmlrpcval($context['forum_tree'], 'array');

    return new xmlrpcresp($response);
}

function authorize_user_func()
{
    global $context;

    $login_status = ($context['user']['is_guest'] || (isset($context['disable_login_hashing']) && $context['disable_login_hashing'])) ? false : true;

    $response = new xmlrpcval(array('authorize_result' => new xmlrpcval($login_status, 'boolean')), 'struct');

    return new xmlrpcresp($response);
}

function login_func()
{
    global $context, $user_info, $modSettings, $user_profile, $settings, $scripturl, $modSettings, $smcFunc;

    $user_info['permissions'] = array();
    loadPermissions();

    $pm_read = !$user_info['is_guest'] && allowedTo('pm_read');
    $pm_send = !$user_info['is_guest'] && allowedTo('pm_send');

    $login_status = ($context['user']['is_guest'] || (isset($context['disable_login_hashing']) && $context['disable_login_hashing'])) ? false : true;
    $result_text = (!$login_status && isset($context['login_errors'][0])) ? $context['login_errors'][0].' '.(isset($context['login_errors'][1])? basic_clean($context['login_errors'][1]) : '') : '';

    $usergroup_id = array();
    foreach ($user_info['groups'] as $group_id)
        $usergroup_id[] = new xmlrpcval($group_id);

    if (!$modSettings['attachmentSizeLimit']) $modSettings['attachmentSizeLimit'] = 5120;
    if (!$modSettings['attachmentNumPerPostLimit']) $modSettings['attachmentNumPerPostLimit'] = 10;

    loadMemberData($user_info['id'], false, 'profile');

    $profile = $user_profile[$user_info['id']];
    if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
        $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
    else
        $avatar = '';

    $user_type = 'normal';
    if (is_numeric($profile['id_group'])) {
        if ($profile['id_group'] == 0) {
            $user_type = 'normal';
        } elseif ($profile['id_group'] == 1) {
            $user_type = 'admin';
        } elseif (($profile['id_group'] == 2) || ($profile['id_group'] == 3)) {
            $user_type = 'mod';
        }
    }
    
    $response = new xmlrpcval(array(
        'result'        => new xmlrpcval($login_status, 'boolean'),
        'result_text'   => new xmlrpcval($result_text, 'base64'),
        'can_pm'        => new xmlrpcval($pm_read, 'boolean'),
        'can_send_pm'   => new xmlrpcval($pm_send, 'boolean'),
        'icon_url'      => new xmlrpcval($avatar, 'string'),
        'post_count'    => new xmlrpcval($profile['posts'], 'int'),
        'user_id'       => new xmlrpcval($user_info['id'], 'string'),
        'username'      => new xmlrpcval(basic_clean($profile['real_name']), 'base64'),
        'login_name'    => new xmlrpcval(basic_clean($profile['member_name']), 'base64'),
        'user_type'     => new xmlrpcval($user_type, 'base64'),
        'email'         => new xmlrpcval($profile['email_address'], 'base64'),
        'usergroup_id'  => new xmlrpcval($usergroup_id, 'array'),
        //'ignored_uids'  => new xmlrpcval($profile['pm_ignore_list'], 'string'),
        'register'      => new xmlrpcval(isset($_POST['emailActivate']) && $_POST['emailActivate'], 'boolean'),
        'max_attachment'=> new xmlrpcval($modSettings['attachmentNumPerPostLimit'], 'int'),
        'max_png_size'  => new xmlrpcval($modSettings['attachmentSizeLimit']*1024, 'int'),
        'max_jpg_size'  => new xmlrpcval($modSettings['attachmentSizeLimit']*1024, 'int'),
        'can_moderate'      => new xmlrpcval($user_info['mod_cache']['bq'] != '0=1' && allowedTo('access_mod_center'), 'boolean'),
        'can_upload_avatar' => new xmlrpcval(allowedTo('profile_upload_avatar'), 'boolean'),
        'can_search'        => new xmlrpcval(allowedTo('search_posts'), 'boolean'),
        'can_whosonline'    => new xmlrpcval(allowedTo('who_view'), 'boolean'),
        'post_countdown'    => new xmlrpcval(allowedTo('moderate_board') ? 0 : $modSettings['spamWaitTime'], 'int'),
    ), 'struct');
    return new xmlrpcresp($response);
}

function login_user_func()
{
    global $context;

    $login_status = ($context['user']['is_guest'] || $context['disable_login_hashing']) ? 0 : 1;

    $response = new xmlrpcval(array('result' => new xmlrpcval($login_status, 'int')), 'struct');

    return new xmlrpcresp($response);
}

function get_topic_func()
{
    global $context, $board_info, $user_profile, $settings, $scripturl, $modSettings, $mode, $subscribed_tids;

    $users = array();
    foreach($context['topics'] as $topic)
    {
        $u_id = $topic['first_post']['member']['id'];
        if(is_numeric($u_id) && $u_id != 0)
            $users[] = $u_id;
    }

    loadMemberData(array_unique($users));

    $topic_list = array();
    foreach($context['topics'] as $topic) {
        if(!isset($topic['id']) || empty($topic['id']))
            continue;
        $avatar = '';
        if (!empty($topic['first_post']['member']['id'])) {
            $profile = $user_profile[$topic['first_post']['member']['id']];

            if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
            {
                $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
            }
        }
        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($board_info['id'], 'string'),
            //'forum_name'        => new xmlrpcval(basic_clean($board_info['name']), 'base64'),
            'topic_id'          => new xmlrpcval($topic['id'], 'string'),
            'topic_title'       => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
            'topic_author_id'   => new xmlrpcval($topic['first_post']['member']['id'], 'string'),
            'topic_author_name' => new xmlrpcval(basic_clean($topic['first_post']['member']['name']), 'base64'),
            'last_reply_time'   => new xmlrpcval($topic['last_post']['time'],'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($topic['last_post']['timestamp'], 'string'),
            'reply_number'      => new xmlrpcval($topic['replies'], 'int'),
            'view_number'       => new xmlrpcval($topic['views'], 'int'),
            'short_content'     => new xmlrpcval(basic_clean($topic['first_post']['preview'], 0, 1), 'base64'),
            'icon_url'          => new xmlrpcval($avatar, 'string'),
            'new_post'          => new xmlrpcval($topic['new'], 'boolean'),
            'can_subscribe'     => new xmlrpcval($context['can_mark_notify'], 'boolean'),
            'is_subscribed'     => new xmlrpcval(in_array($topic['id'], $subscribed_tids), 'boolean'),
            'is_moved'          => new xmlrpcval($topic['icon'] == 'moved', 'boolean'),
            
            'can_merge'         => new xmlrpcval(allowedTo('merge_any'), 'boolean'),
            'can_delete'        => new xmlrpcval(allowedTo('remove_any') || ($context['user']['id'] == $topic['first_post']['member']['id'] && allowedTo('remove_own')), 'boolean'),
            'can_close'         => new xmlrpcval(allowedTo('lock_any') || ($context['user']['id'] == $topic['first_post']['member']['id'] && allowedTo('lock_own')), 'boolean'),
            'is_closed'         => new xmlrpcval($topic['is_locked'], 'boolean'),
            'can_stick'         => new xmlrpcval(allowedTo('make_sticky') && !empty($modSettings['enableStickyTopics_old']), 'boolean'),
            'is_sticky'         => new xmlrpcval($topic['is_sticky'], 'boolean'),
            'can_move'          => new xmlrpcval(allowedTo('move_any') || ($context['user']['id'] == $topic['first_post']['member']['id'] && allowedTo('move_own')), 'boolean'),
            'can_rename'        => new xmlrpcval(allowedTo('move_any') || ($context['user']['id'] == $topic['first_post']['member']['id'] && allowedTo('move_own')), 'boolean'),
            'attachment'        => new xmlrpcval($topic['first_post']['icon'] == 'clip' ? 1 : 0, 'string'),
        ), 'struct');

        $topic_list[] = $xmlrpc_topic;
    }

    $mobiquo_can_post = true;
    if(isset($modSettings['boards_disable_new_topic']) && !empty($modSettings['boards_disable_new_topic']))
    {
        $dis_new_topic_boards = explode(',',$modSettings['boards_disable_new_topic']);
        $mobiquo_can_post = !in_array($_GET['board'], $dis_new_topic_boards);
    }

    $response = new xmlrpcval(
        array(
            'total_topic_num' => new xmlrpcval($mode == 'TOP' ? $board_info['sticky_num'] : $board_info['total_topics'] - $board_info['sticky_num'], 'int'),
        'unread_sticky_count' => new xmlrpcval($board_info['unread_sticky_num'], 'int'),
            'forum_id'        => new xmlrpcval($board_info['id'], 'string'),
            'forum_name'      => new xmlrpcval(basic_clean($board_info['name']), 'base64'),
            'topics'          => new xmlrpcval($topic_list, 'array'),
            'can_post'        => new xmlrpcval($context['can_post_new'] && $mobiquo_can_post ? true : false, 'boolean'),
            'can_upload'      => new xmlrpcval($context['can_post_attachment'] ? true : false, 'boolean'),
        ),
        'struct'
    );

    return new xmlrpcresp($response);
}

function get_thread_func()
{
    global $context, $settings, $options, $txt, $smcFunc, $scripturl, $modSettings, $user_profile, $user_info, $topicinfo;
    
    $rpc_post_list = array();
    $post_place = 0;
    $msg_ids = array();
    $support_post_thanks = isset($modSettings['integrate_pre_include']) && strpos($modSettings['integrate_pre_include'],'$sourcedir/Subs-ThankYou.php');
    while ($message = get_post_detail()) {
        $attachments = array();
        if(!empty($message['attachment'])) {
            foreach($message['attachment'] as $attachment)
            {
                $extension = pathinfo($attachment['name'], PATHINFO_EXTENSION);
                if(empty($extension))
                    $extension = 'other';
                $xmlrpc_attachment = new xmlrpcval(array(
                    'filename'      => new xmlrpcval(basic_clean($attachment['name']), 'base64'),
                    'filesize'      => new xmlrpcval($attachment['byte_size'], 'int'),
                    'content_type'  => new xmlrpcval($attachment['is_image'] ? 'image' : $extension),
                    'thumbnail_url' => new xmlrpcval($attachment['thumbnail']['has_thumb'] ? $attachment['thumbnail']['href'] : ''),
                    'url'           => new xmlrpcval($attachment['href'])
                ), 'struct');
                $attachments[] = $xmlrpc_attachment;
            }
        }

        $avatar = '';
        if (!empty($settings['show_user_images']) && empty($options['show_no_avatars']) && !empty($message['member']['avatar']['image']))
        {
            $avatar = $message['member']['avatar']['href'];
        }
        $msg_ids[] = $message['id'];

        $xmlrpc_post = array(
            'topic_id'          => new xmlrpcval($context['current_topic'], 'string'),
            'post_id'           => new xmlrpcval($message['id']),
            'post_title'        => new xmlrpcval(basic_clean($message['subject']), 'base64'),
            'post_content'      => new xmlrpcval(post_html_clean($message['body']), 'base64'),
            'post_author_id'    => new xmlrpcval($message['member']['id']),
            'post_author_name'  => new xmlrpcval(basic_clean($message['member']['name']), 'base64'),
            'icon_url'          => new xmlrpcval($avatar),
            'post_time'         => new xmlrpcval($message['time'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($message['timestamp'], 'string'),
            'attachments'       => new xmlrpcval($attachments, 'array'),

            'is_online'         => new xmlrpcval(isset($message['member']['online']['is_online']) && $message['member']['online']['is_online'] ? true : false, 'boolean'),
            'can_edit'          => new xmlrpcval($message['can_modify'], 'boolean'),
            'can_delete'        => new xmlrpcval($message['can_remove'], 'boolean'),
            'allow_smilies'     => new xmlrpcval($message['smileys_enabled'] ? true : false, 'boolean'),

//            'is_buddy'          => new xmlrpcval($message['member']['is_buddy'] ? true : false, 'boolean'),
//            'is_reverse_buddy'  => new xmlrpcval($message['member']['is_reverse_buddy'] ? true : false, 'boolean'),
//            'can_view_profile'  => new xmlrpcval($message['member']['can_view_profile'] ? true : false, 'boolean'),
//            'approved'          => new xmlrpcval($message['approved'] ? true : false, 'boolean'),
//            'first_new'         => new xmlrpcval($message['first_new'] ? true : false, 'boolean'),
//            'is_ignored'        => new xmlrpcval($message['is_ignored'] ? true : false, 'boolean'),
//            'can_approve'       => new xmlrpcval($message['can_approve'] ? true : false, 'boolean'),
//            'can_unapprove'     => new xmlrpcval($message['can_unapprove'] ? true : false, 'boolean'),

        );
        
        if ($settings['show_modify'] && $message['modified'] && $message['modified']['name'])
        {
            $loaded_ids = loadMemberData($message['modified']['name'], true);
            $xmlrpc_post['editor_id']       = new xmlrpcval($loaded_ids[0], 'string');
            $xmlrpc_post['editor_name']     = new xmlrpcval(basic_clean($message['modified']['name']), 'base64');
            $xmlrpc_post['edit_time']     = new xmlrpcval($message['modified']['timestamp'], 'string');
        }

        $rpc_post_list[] = $xmlrpc_post;
    }
    global $board_info;
    $fixed_rpc_post_list = array();
    if ($support_post_thanks)
    {   
        if ($board_info['thank_you_post_enable'] && allowedTo('thank_you_post_show'))
        {
            if(function_exists('ThankYouPostList'))
                ThankYouPostList($msg_ids);
            else
            {
                global $sourcedir;
                include_once($sourcedir . '/ThankYouPost.php');
                ThankYouPostList($msg_ids);
            }
        }
            
        if(!empty($context['topic_first_message']) && !empty($modSettings['thankYouPostFirstPostOnly']))
        {
            foreach($context['thank_you_post_info'] as $one_msg => $msg)
                if($msg['id_msg'] == $context['topic_first_message'])
                $first_msg_thank_count = $msg['thank_you_post_counter'];
        }
        foreach ($rpc_post_list as $one_post => $xmlrpc_post)
        {
            $thx_info_list = array();
            $rpc_me_name = "me";
            $me_value = $xmlrpc_post['post_id'] -> $rpc_me_name;
            $msg_id = $me_value['string'];
            $me_author_id = $xmlrpc_post['post_author_id'] -> $rpc_me_name;
    
            $already_posted = $user_info['id'] == $me_author_id['string'] ? true: false;
            if(isset($context['thank_you_post'][$msg_id]))
            {
                $member_list = $context['thank_you_post'][$msg_id]['fulllist'];
                foreach($member_list as $one_thank_member => $one)
                {
                    $thx_info_list[] = new xmlrpcval(array(
                                'userid' => new xmlrpcval($one['id_member'], 'string'),
                                'username' => new xmlrpcval($one['member_name'], 'base64')
                            ), 'struct');
                    if ($user_info['id'] == $one['id_member'])
                        $already_posted = true;
                }

                $is_the_post_locked = ($context['thank_you_post_info'][$msg_id]['thank_you_post'] == 2);
                $can_thank_if_not_locked = $board_info['thank_you_post_enable'] && !$context['thank_you_post'][$msg_id]['user_postet'] && allowedTo('thank_you_post_post') && !$already_posted;
            }
            else
            {
                $is_the_post_locked = isset($context['thank_you_post_info'][$msg_id]) && ($context['thank_you_post_info'][$msg_id]['thank_you_post'] == 2);
                $can_thank_if_not_locked = $board_info['thank_you_post_enable'] && allowedTo('thank_you_post_post') && !$already_posted;
            }
            $xmlrpc_post['can_thank'] = new xmlrpcval($can_thank_if_not_locked && !$is_the_post_locked && !$context['is_thank_you_post_locked'], 'boolean');
            if (!empty($thx_info_list) && $board_info['thank_you_post_enable'] && allowedTo('thank_you_post_show'))
                    $xmlrpc_post['thanks_info'] = new xmlrpcval($thx_info_list, 'array');
            $fixed_rpc_post_list[] = new xmlrpcval($xmlrpc_post, 'struct');
        }
    }
    else
    {
        foreach ($rpc_post_list as $one_post => $xmlrpc_post)
            $fixed_rpc_post_list[] = new xmlrpcval($xmlrpc_post, 'struct');
    }
    $rpc_post_list = $fixed_rpc_post_list;

    $context['num_allowed_attachments'] = empty($modSettings['attachmentNumPerPostLimit']) ? 50 : $modSettings['attachmentNumPerPostLimit'];
    $context['can_post_attachment'] = !empty($modSettings['attachmentEnable']) && $modSettings['attachmentEnable'] == 1 && (allowedTo('post_attachment') || ($modSettings['postmod_active'] && allowedTo('post_unapproved_attachments'))) && $context['num_allowed_attachments'] > 0;

    //generate breadcrumbs
    $breadcrumbs = array();
    $breadcrumbs[] = array('id' => 'c'.$board_info['cat']['id'], 'name' => $board_info['cat']['name'], 'sub_only' => 1);
    foreach($board_info['parent_boards'] as $pbid => $cont)
        $board_info['parent_boards'][$pbid]['id'] = $pbid;
    $parent_boards = array_reverse($board_info['parent_boards']);
    if(!empty($parent_boards) && is_array($parent_boards))
        foreach($parent_boards as $bd_content)
            $breadcrumbs[] = array('id' => $bd_content['id'], 'name' => $bd_content['name'], 'sub_only' => 0);
    
    $breadcrumbs[] = array('id' => $board_info['id'], 'name' => $board_info['name'], 'sub_only' => 0);
    
    $can_modify = (!$context['is_locked'] || allowedTo('moderate_board')) 
                   && (allowedTo('modify_any') || (allowedTo('modify_replies') && $context['user']['started']) || (allowedTo('modify_own') && $context['user']['started']));
    
    $response = array(
        'total_post_num' => new xmlrpcval($context['total_visible_posts'], 'int'),
        'forum_id'       => new xmlrpcval($context['current_board'], 'string'),
        'forum_name'     => new xmlrpcval(basic_clean($board_info['name']), 'base64'),
        'topic_id'       => new xmlrpcval($context['current_topic'], 'string'),
        'topic_title'    => new xmlrpcval(basic_clean($context['subject']), 'base64'),
        'view_number'    => new xmlrpcval($context['num_views'], 'int'),
        'can_subscribe'  => new xmlrpcval($context['can_mark_notify'], 'boolean'),
        'is_subscribed'  => new xmlrpcval($context['is_marked_notify'], 'boolean'),
        'is_poll'        => new xmlrpcval($topicinfo['id_poll'], 'boolean'),
        'can_stick'      => new xmlrpcval($context['can_sticky'], 'boolean'),
        'is_sticky'      => new xmlrpcval($context['is_sticky'], 'boolean'),
        'can_reply'      => new xmlrpcval($context['can_reply'], 'boolean'),
        'can_delete'     => new xmlrpcval($context['can_delete'], 'boolean'),
        'can_upload'     => new xmlrpcval($context['can_post_attachment'], 'boolean'),
        'can_close'      => new xmlrpcval($context['can_lock'], 'boolean'),
        'is_closed'      => new xmlrpcval($context['is_locked'], 'boolean'),
        'position'       => new xmlrpcval($context['new_position'], 'int'),
        'can_move'       => new xmlrpcval($context['can_move'], 'boolean'),
        'can_report'     => new xmlrpcval(true, 'boolean'),
        'can_merge'      => new xmlrpcval($context['can_merge'] ? true : false, 'boolean'),
        'can_rename'     => new xmlrpcval($can_modify, 'boolean'),
//                'is_very_hot'           => new xmlrpcval($context['is_very_hot'] ? true : false, 'boolean'),
//                'is_hot'                => new xmlrpcval($context['is_hot'] ? true : false, 'boolean'),
//                'is_approved'           => new xmlrpcval($context['is_approved'] ? true : false, 'boolean'),
//                'is_poll'               => new xmlrpcval($context['is_marked_notify'] ? true : false, 'boolean'),
//                'can_approve'           => new xmlrpcval($context['can_approve'] ? true : false, 'boolean'),
//                'can_ban'               => new xmlrpcval($context['can_ban'] ? true : false, 'boolean'),
//                'can_split'             => new xmlrpcval($context['can_split'] ? true : false, 'boolean'),
//                'can_mark_notify'       => new xmlrpcval($context['can_mark_notify'] ? true : false, 'boolean'),
//                'can_send_topic'        => new xmlrpcval($context['can_send_topic'] ? true : false, 'boolean'),
//                'can_send_pm'           => new xmlrpcval($context['can_send_pm'] ? true : false, 'boolean'),
//                'can_report_moderator'  => new xmlrpcval($context['can_report_moderator'] ? true : false, 'boolean'),
//                'can_moderate_forum'    => new xmlrpcval($context['can_moderate_forum'] ? true : false, 'boolean'),
//                'can_issue_warning'     => new xmlrpcval($context['can_issue_warning'] ? true : false, 'boolean'),
//                'can_restore_topic'     => new xmlrpcval($context['can_restore_topic'] ? true : false, 'boolean'),
//                'can_restore_msg'       => new xmlrpcval($context['can_restore_msg'] ? true : false, 'boolean'),
//                'can_add_poll'          => new xmlrpcval($context['can_add_poll'] ? true : false, 'boolean'),
//                'can_remove_poll'       => new xmlrpcval($context['can_remove_poll'] ? true : false, 'boolean'),
//                'can_reply_unapproved'  => new xmlrpcval($context['can_reply_unapproved'] ? true : false, 'boolean'),
//                'can_reply_approved'    => new xmlrpcval($context['can_reply_approved'] ? true : false, 'boolean'),
//                'can_mark_unread'       => new xmlrpcval($context['can_mark_unread'] ? true : false, 'boolean'),
//                'can_remove_post'       => new xmlrpcval($context['can_remove_post'] ? true : false, 'boolean'),
    );
    if(!empty($breadcrumbs))
    {
        $breadcrumblist = array();
        foreach($breadcrumbs as $node)
        {
            $breadcrumblist[] = new xmlrpcval(array(
                'forum_id'      => new xmlrpcval($node['id'], 'string'),
                'forum_name'    => new xmlrpcval(basic_clean($node['name']), 'base64'),
                'sub_only'      => new xmlrpcval($node['sub_only'], 'boolean'),
            ), 'struct');
        }
        if(!empty($breadcrumblist))
            $response['breadcrumb'] = new xmlrpcval($breadcrumblist, 'array');
    }
    if (isset($first_msg_thank_count) && !empty($modSettings['thankYouPostFirstPostOnly']))
    {
       $response['thank_count'] = new xmlrpcval($first_msg_thank_count, 'int');
    }
    $response['posts'] = new xmlrpcval($rpc_post_list, 'array');

    return new xmlrpcresp(new xmlrpcval($response, 'struct'));
}

function get_board_stat_func()
{
    global $context, $modSettings;

    $board_stat = array(
        'total_threads' => new xmlrpcval($modSettings['totalTopics'], 'int'),
        'total_posts'   => new xmlrpcval($modSettings['totalMessages'], 'int'),
        'total_members' => new xmlrpcval($modSettings['totalMembers'], 'int'),
        'guest_online'  => new xmlrpcval($context['num_guests'], 'int'),
        'total_online'  => new xmlrpcval($context['num_guests'] + $context['num_users_online'], 'int'),

        //'num_buddies'      => new xmlrpcval($context['num_buddies'], 'int'),
        //'num_users_hidden' => new xmlrpcval($context['num_users_hidden'], 'int'),
    );

    $response = new xmlrpcval($board_stat, 'struct');

    return new xmlrpcresp($response);
}

function get_online_users_func()
{
    global $context, $user_profile, $settings, $scripturl, $modSettings;

    $users = array();
    foreach($context['members'] as $user)
    {
        $users[] = $user['id'];
    }

    loadMemberData($users);

    $user_list = array();
    foreach($context['members'] as $user)
    {
        $profile = $user_profile[$user['id']];
        $avatar = '';
        if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
        {
            $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
        }
        $from = 'browser';
        if(isset($user['query']['USER_AGENT']))
        {
            $userAgent = $user['query']['USER_AGENT'];
            if(strpos($userAgent,'Android') !== false || strpos($userAgent,'iPhone') !== false || strpos($userAgent,'BlackBerry') !== false)
                $from = 'mobile';
            if(strpos($userAgent,'Tapatalk') !== false)
                $from = 'tapatalk';
            if(strpos($userAgent,'BYO') !== false)
                $from = 'byo';
        }
        $user_list[] = new xmlrpcval(array(
            'user_id'       => new xmlrpcval($user['id'], 'string'),
            'user_name'     => new xmlrpcval(basic_clean($user['name']), 'base64'),
            'display_text'  => new xmlrpcval(basic_clean($user['action']), 'base64'),
            'from'          => new xmlrpcval($from, 'string'),
            'icon_url'      => new xmlrpcval($avatar)
        ), 'struct');
    }

    action_get_board_stat();

    $online_users = array(
        'member_count' => new xmlrpcval($context['num_users_online'], 'int'),
        'guest_count'  => new xmlrpcval($context['num_guests'], 'int'),
        'list'         => new xmlrpcval($user_list, 'array')
    );

    $response = new xmlrpcval($online_users, 'struct');

    return new xmlrpcresp($response);
}

function get_user_info_func()
{
    global $context, $txt, $modSettings, $user_info, $smcFunc;

    $custom_fields = array();

    if (!empty($context['member']['group']) || !empty($context['member']['post_group'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['position'], 'base64'),
            'value' => new xmlrpcval(!empty($context['member']['group']) ? $context['member']['group'] : $context['member']['post_group'], 'base64')
        ), 'struct');
    }

    if ($context['member']['show_email'] == 'yes' || $context['member']['show_email'] == 'yes_permission_override') {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['email'], 'base64'),
            'value' => new xmlrpcval($context['member']['email'], 'base64')
        ), 'struct');
    }

    if ($context['member']['website']['url'] != '' && !isset($context['disabled_fields']['website'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['website_title'], 'base64'),
            'value' => new xmlrpcval($context['member']['website']['url'], 'base64')
        ), 'struct');
    }

    if (!isset($context['disabled_fields']['icq']) && !empty($context['member']['icq']['link'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['icq'], 'base64'),
            'value' => new xmlrpcval($context['member']['icq']['name'], 'base64')
        ), 'struct');
    }

    if (!isset($context['disabled_fields']['msn']) && !empty($context['member']['msn']['link'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['msn'], 'base64'),
            'value' => new xmlrpcval($context['member']['msn']['name'], 'base64')
        ), 'struct');
    }

    if (!isset($context['disabled_fields']['aim']) && !empty($context['member']['aim']['link'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['aim'], 'base64'),
            'value' => new xmlrpcval($context['member']['aim']['name'], 'base64')
        ), 'struct');
    }

    if (!isset($context['disabled_fields']['yim']) && !empty($context['member']['yim']['link'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['yim'], 'base64'),
            'value' => new xmlrpcval($context['member']['yim']['name'], 'base64')
        ), 'struct');
    }

    if (!empty($modSettings['titlesEnable']) && !empty($context['member']['title'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['custom_title'], 'base64'),
            'value' => new xmlrpcval(basic_clean($context['member']['title']), 'base64')
        ), 'struct');
    }

    if ($modSettings['karmaMode'] == '1') {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($modSettings['karmaLabel'], 'base64'),
            'value' => new xmlrpcval($context['member']['karma']['good'] - $context['member']['karma']['bad'], 'base64')
        ), 'struct');
    } elseif ($modSettings['karmaMode'] == '2') {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($modSettings['karmaLabel'], 'base64'),
            'value' => new xmlrpcval('+'.$context['member']['karma']['good'].'/-'.$context['member']['karma']['bad'], 'base64')
        ), 'struct');
    }

    if (!isset($context['disabled_fields']['gender']) && !empty($context['member']['gender']['name'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['gender'], 'base64'),
            'value' => new xmlrpcval($context['member']['gender']['name'], 'base64')
        ), 'struct');
    }

    if ($context['member']['age']) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['age'], 'base64'),
            'value' => new xmlrpcval($context['member']['age'], 'base64')
        ), 'struct');
    }

    if (!isset($context['disabled_fields']['location']) && !empty($context['member']['location'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['location'], 'base64'),
            'value' => new xmlrpcval(basic_clean($context['member']['location']), 'base64')
        ), 'struct');
    }

    if ($context['can_view_warning'] && $context['member']['warning']) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['profile_warning_level'], 'base64'),
            'value' => new xmlrpcval($context['member']['warning'].'%', 'base64')
        ), 'struct');
    }

    if ($context['can_see_ip']) {
        if (!empty($context['member']['ip'])) {
            $custom_fields[] = new xmlrpcval(array(
                'name'  => new xmlrpcval($txt['ip'], 'base64'),
                'value' => new xmlrpcval($context['member']['ip'], 'base64')
            ), 'struct');
        }

        if (empty($modSettings['disableHostnameLookup']) && !empty($context['member']['ip'])) {
            $custom_fields[] = new xmlrpcval(array(
                'name'  => new xmlrpcval($txt['hostname'], 'base64'),
                'value' => new xmlrpcval($context['member']['hostname'], 'base64')
            ), 'struct');
        }
    }

    if (!empty($modSettings['userLanguage']) && !empty($context['member']['language'])) {
        $custom_fields[] = new xmlrpcval(array(
            'name'  => new xmlrpcval($txt['language'], 'base64'),
            'value' => new xmlrpcval($context['member']['language'], 'base64')
        ), 'struct');
    }
    
    //Add push status custom fields
    if(isset($_GET['u']) && !empty($_GET['u']))
        $queried_userid = $_GET['u'];
    else
    {
        $loaded_id = loadMemberData($_GET['user'], true);
        $queried_userid = is_array($loaded_id)? $loaded_id[0] : $loaded_id;
    }
    $xmlrpc_user_info = new xmlrpcval(array(
        'user_id'               => new xmlrpcval($context['member']['id'], 'string'),
        'post_count'            => new xmlrpcval(!isset($context['disabled_fields']['posts']) ? $context['member']['posts'] : '', 'int'),
        'reg_time'              => new xmlrpcval($context['member']['registered'], 'dateTime.iso8601'),
        'reg_timestamp'         => new xmlrpcval($context['member']['registered_timestamp'], 'string'),
        'timestamp'             => new xmlrpcval($context['member']['last_login_timestamp'], 'string'),
        'last_activity_time'    => new xmlrpcval($context['member']['last_login'], 'dateTime.iso8601'),
        'icon_url'              => new xmlrpcval($context['member']['avatar']['href']),
        'username'              => new xmlrpcval(basic_clean($context['member']['name']), 'base64'),
        'display_text'          => new xmlrpcval(basic_clean($context['member']['blurb']), 'base64'),
        'is_online'             => new xmlrpcval($context['member']['online']['is_online'], 'boolean'),
        'can_ban'               => new xmlrpcval(!empty($context['menu_data_1']['sections']['profile_action']['areas']['banuser']), 'boolean'),
        'is_ban'                => new xmlrpcval($context['member']['is_banned'], 'boolean'),
        'can_upload'            => new xmlrpcval(allowedTo('profile_upload_avatar') && $context['user']['is_owner'], 'boolean'),
        'can_send_pm'           => new xmlrpcval($context['can_send_pm'], 'boolean'),
        'accept_pm'             => new xmlrpcval(allowedTo('pm_send'), 'boolean'),
//        'is_buddy'              => new xmlrpcval($context['member']['is_buddy'], 'boolean'),
//        'can_have_buddy'        => new xmlrpcval(!empty($context['can_have_buddy']) && !$context['user']['is_owner'], 'boolean'),
        'custom_fields_list'    => new xmlrpcval($custom_fields, 'array'),
    ), 'struct');

    return new xmlrpcresp($xmlrpc_user_info);
}


function get_user_reply_post_func()
{
    global $context;

    $post_list = array();
    foreach($context['posts'] as $post)
    {
        $topic_info = get_topic_info($post['board']['id'], $post['topic']);

        $xmlrpc_post = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($post['board']['id']),
            'forum_name'        => new xmlrpcval(basic_clean($post['board']['name']), 'base64'),
            'topic_id'          => new xmlrpcval($post['topic']),
            'topic_title'       => new xmlrpcval(basic_clean($topic_info['first_subject']), 'base64'),
            'post_id'           => new xmlrpcval($post['id']),
            'post_title'        => new xmlrpcval(basic_clean($post['subject']), 'base64'),
            'short_content'     => new xmlrpcval(basic_clean($post['body'], 100), 'base64'),
            'icon_url'          => new xmlrpcval($topic_info['first_poster_avatar']),
            'post_time'         => new xmlrpcval($post['time'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($post['timestamp'], 'string'),
            'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
            'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
            'new_post'          => new xmlrpcval($topic_info['new'] ? true : false, 'boolean'),
            'can_subscribe'     => new xmlrpcval($post['can_mark_notify'], 'boolean'),
            'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),

            'can_move'          => new xmlrpcval(allowedTo('move_any') || ($context['user']['is_owner'] && allowedTo('move_own')), 'boolean'),
            'can_delete'        => new xmlrpcval($post['can_delete'] && $post['delete_possible'] ? true : false, 'boolean'),
        ), 'struct');

        $post_list[] = $xmlrpc_post;
    }

    return new xmlrpcresp(new xmlrpcval($post_list, 'array'));
}

function get_user_topic_func()
{
    global $context, $modSettings;

    $topic_list = array();
    foreach($context['posts'] as $topic)
    {
        $topic_info = get_topic_info($topic['board']['id'], $topic['topic']);

        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($topic['board']['id']),
            'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
            'topic_id'          => new xmlrpcval($topic['topic']),
            'topic_title'       => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
 'last_reply_author_name'       => new xmlrpcval(basic_clean($topic_info['last_display_name']), 'base64'),
            'short_content'     => new xmlrpcval(basic_clean($topic_info['first_body']), 'base64'),
            'icon_url'          => new xmlrpcval($topic_info['last_poster_avatar']),
            'last_reply_time'   => new xmlrpcval($topic_info['last_poster_time'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($topic_info['last_poster_timestamp'], 'string'),
            'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
            'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
            'new_post'          => new xmlrpcval($topic_info['new'], 'boolean'),
            'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'] , 'boolean'),
            'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
            'is_closed'         => new xmlrpcval($topic_info['is_locked'], 'boolean'),
            'is_sticky'          => new xmlrpcval($topic_info['is_sticky'], 'boolean'),

            'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
            'can_close'         => new xmlrpcval($topic_info['can_lock'] , 'boolean'),
            'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
            'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
            'can_rename'        => new xmlrpcval($topic_info['can_move'], 'boolean'),
        ), 'struct');

        $topic_list[] = $xmlrpc_topic;
    }

    return new xmlrpcresp(new xmlrpcval($topic_list, 'array'));
}

function get_participated_forum_func()
{
    global $context;

    $board_list = array();
    foreach($context['boards'] as $board)
    {
        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'      => new xmlrpcval($board['id'], 'string'),
            'forum_name'    => new xmlrpcval(basic_clean($board['name']), 'base64'),
            'icon_url'      => new xmlrpcval($board['logo']),
            'new_post'      => new xmlrpcval($board['new'] ? true : false, 'boolean'),
        ), 'struct');

        $board_list[] = $xmlrpc_topic;
    }

    $response = new xmlrpcval(array(
        'total_forums_num'  => new xmlrpcval(count($board_list), 'int'),
        'forums'            => new xmlrpcval($board_list, 'array'),
    ), 'struct');

    return new xmlrpcresp($response);
}


function get_unread_topic_func()
{
    global $context, $user_info, $mode;

    $topic_list = array();
    foreach($context['topics'] as $topic)
    {
        $topic_info = get_topic_info($topic['board']['id'], $topic['id']);

        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($topic['board']['id'], 'string'),
            'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
            'topic_id'          => new xmlrpcval($topic['id'], 'string'),
            'topic_title'       => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
            'post_author_name'  => new xmlrpcval(basic_clean($topic['last_post']['member']['name']), 'base64'),
            'post_time'         => new xmlrpcval($topic['last_post']['time'],'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($topic['last_post']['timestamp'], 'string'),
            'reply_number'      => new xmlrpcval($topic['replies'], 'int'),
            'view_number'       => new xmlrpcval($topic['views'], 'int'),
            'short_content'     => new xmlrpcval(basic_clean($topic_info['last_body'], 0, 1), 'base64'),
            'icon_url'          => new xmlrpcval($topic_info['last_poster_avatar']),
            'new_post'          => new xmlrpcval(true, 'boolean'),
            'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'], 'boolean'),
            'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
            'is_closed'         => new xmlrpcval($topic['is_locked'], 'boolean'),
            'is_sticky'          => new xmlrpcval($topic['is_sticky'], 'boolean'),

            'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
            'can_close'         => new xmlrpcval($topic_info['can_lock'], 'boolean'),
            'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
            'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
            'can_rename'        => new xmlrpcval($topic_info['can_move'], 'boolean'),
        ), 'struct');

        $topic_list[] = $xmlrpc_topic;
    }

    $total_unread_topic_num = isset($context['num_topics']) ? $context['num_topics'] : 0;

    $response = new xmlrpcval(
        array(
            'total_topic_num' => new xmlrpcval($total_unread_topic_num, 'int'),
            'topics'          => new xmlrpcval($topic_list, 'array'),
        ),
        'struct'
    );

    return new xmlrpcresp($response);
}

function get_forum_status_func()
{
    global $context;

    $board_list = array();
    foreach($context['boards'] as $board)
    {
        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'      => new xmlrpcval($board['id'], 'string'),
            'forum_name'    => new xmlrpcval(basic_clean($board['name']), 'base64'),
            'icon_url'      => new xmlrpcval($board['logo']),
            'new_post'      => new xmlrpcval($board['new'] ? true : false, 'boolean'),
        ), 'struct');

        $board_list[] = $xmlrpc_topic;
    }

    $response = new xmlrpcval(array(
        'forums'            => new xmlrpcval($board_list, 'array'),
    ), 'struct');

    return new xmlrpcresp($response);
}

function get_new_topic_func()
{
    global $context;

    $topic_list = array();
    foreach ($context['posts'] as $topic)
    {
        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($topic['board']['id']),
            'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
            'topic_id'          => new xmlrpcval($topic['topic']),
            'topic_title'       => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
            'reply_number'      => new xmlrpcval($topic['replies'], 'int'),
            'view_number'       => new xmlrpcval($topic['views'], 'int'),
            'short_content'     => new xmlrpcval(basic_clean($topic['preview'], 0, 1), 'base64'),
            'post_author_id'    => new xmlrpcval($topic['poster']['id']),
            'post_author_name'  => new xmlrpcval(basic_clean($topic['poster']['name']), 'base64'),
            'new_post'          => new xmlrpcval($topic['is_new'], 'boolean'),
            'post_time'         => new xmlrpcval($topic['time'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($topic['timestamp'], 'string'),
            'icon_url'          => new xmlrpcval($topic['poster']['avatar']),
            'can_subscribe'     => new xmlrpcval($topic['can_mark_notify'], 'boolean'),
            'is_subscribed'     => new xmlrpcval($topic['is_marked_notify'], 'boolean'),
            'is_closed'         => new xmlrpcval($topic['is_locked'], 'boolean'),
            'is_sticky'          => new xmlrpcval($topic['is_sticky'], 'boolean'),

            'can_delete'        => new xmlrpcval($topic['can_remove'], 'boolean'),
            'can_close'         => new xmlrpcval($topic['can_lock'], 'boolean'),
            'can_stick'         => new xmlrpcval($topic['can_sticky'], 'boolean'),
            'can_move'          => new xmlrpcval($topic['can_move'], 'boolean'),
            'can_rename'        => new xmlrpcval($topic['can_move'], 'boolean'),
        ), 'struct');

        $topic_list[] = $xmlrpc_topic;
    }

    return new xmlrpcresp(new xmlrpcval($topic_list, 'array'));
}

function get_latest_topic_func()
{
    global $context, $modSettings, $topic_per_page, $start_num;

    $topic_list = array();
    foreach ($context['posts'] as $topic)
    {   
        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($topic['board']['id']),
            'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
            'topic_id'          => new xmlrpcval($topic['topic']),
            'topic_title'       => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
            'reply_number'      => new xmlrpcval($topic['replies'], 'int'),
            'view_number'       => new xmlrpcval($topic['views'], 'int'),
            'short_content'     => new xmlrpcval(basic_clean($topic['preview'], 0, 1), 'base64'),
            'post_author_id'    => new xmlrpcval($topic['poster']['id']),
            'post_author_name'  => new xmlrpcval(basic_clean($topic['poster']['name']), 'base64'),
            'new_post'          => new xmlrpcval($topic['is_new'], 'boolean'),
            'post_time'         => new xmlrpcval($topic['time'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($topic['timestamp'], 'string'),
            'icon_url'          => new xmlrpcval($topic['poster']['avatar']),
            'can_subscribe'     => new xmlrpcval($topic['can_mark_notify'], 'boolean'),
            'is_subscribed'     => new xmlrpcval($topic['is_marked_notify'], 'boolean'),
            'is_closed'         => new xmlrpcval($topic['is_locked'], 'boolean'),
            'is_sticky'          => new xmlrpcval($topic['is_sticky'], 'boolean'),

            'can_delete'        => new xmlrpcval($topic['can_remove'], 'boolean'),
            'can_close'         => new xmlrpcval($topic['can_lock'], 'boolean'),
            'can_stick'         => new xmlrpcval($topic['can_sticky'], 'boolean'),
            'can_move'          => new xmlrpcval($topic['can_move'], 'boolean'),
            'can_rename'        => new xmlrpcval($topic['can_move'], 'boolean'),
        ), 'struct');

        $topic_list[] = $xmlrpc_topic;
    }
    $total_topic_num = min(100, $modSettings['totalTopics']);

    if(count($topic_list) < $topic_per_page && $start_num == 0)
        $total_topic_num = count($topic_list);
    $response = new xmlrpcval(array(
        'result'    => new xmlrpcval(true, 'boolean'),
        'total_topic_num' => new xmlrpcval($total_topic_num, 'int'),
        'topics' => new xmlrpcval($topic_list, 'array'),
    ), 'struct');

    return new xmlrpcresp($response);
}

function get_subscribed_forum_func()
{
    global $context;

    $board_list = array();
    foreach($context['boards'] as $board)
    {
        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'      => new xmlrpcval($board['id'], 'string'),
            'forum_name'    => new xmlrpcval(basic_clean($board['name']), 'base64'),
            'icon_url'      => new xmlrpcval($board['logo']),
            'new_post'      => new xmlrpcval($board['new'] ? true : false, 'boolean'),
        ), 'struct');

        $board_list[] = $xmlrpc_topic;
    }

    $response = new xmlrpcval(
        array(
            'total_forums_num' => new xmlrpcval(count($context['boards']), 'int'),
            'forums' => new xmlrpcval($board_list, 'array'),
        ),
        'struct'
    );

    return new xmlrpcresp($response);
}




function get_subscribed_topic_func()
{
    global $context;

    $topic_list = array();
    foreach ($context['topics'] as $topic)
    {
        $topic_info = get_topic_info($topic['id_board'], $topic['id_topic']);

        $xmlrpc_topic = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($topic['id_board']),
            'forum_name'        => new xmlrpcval(basic_clean($topic['board_name']), 'base64'),
            'topic_id'          => new xmlrpcval($topic_info['id_topic']),
            'topic_title'       => new xmlrpcval(basic_clean($topic_info['first_subject']), 'base64'),
            'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
            'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
            'short_content'     => new xmlrpcval(basic_clean($topic_info['last_body'], 0, 1), 'base64'),
            'post_author_name'  => new xmlrpcval(basic_clean($topic_info['last_display_name']), 'base64'),
            'new_post'          => new xmlrpcval($topic_info['new'] ? true : false, 'boolean'),
            'post_time'         => new xmlrpcval($topic_info['last_poster_time'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($topic_info['last_poster_timestamp'], 'string'),
            'icon_url'          => new xmlrpcval($topic_info['last_poster_avatar']),
            'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'], 'boolean'),
            'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
            'is_closed'         => new xmlrpcval($topic_info['is_locked'], 'boolean'),
            'is_sticky'          => new xmlrpcval($topic_info['is_sticky'], 'boolean'),

            'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
            'can_close'         => new xmlrpcval($topic_info['can_lock'], 'boolean'),
            'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
            'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
            'can_rename'        => new xmlrpcval($topic_info['can_move'], 'boolean'),
        ), 'struct');

        $topic_list[] = $xmlrpc_topic;
    }

    $response = new xmlrpcval(
        array(
            'total_topic_num' => new xmlrpcval($context['topic_num'], 'int'),
            'topics'          => new xmlrpcval($topic_list, 'array'),
        ),
        'struct'
    );

    return new xmlrpcresp($response);
}

function create_topic_func()
{
    global $new_topic_id, $is_approved;

    $xmlrpc_create_topic = new xmlrpcval(array(
        'result'    => new xmlrpcval($new_topic_id ? true : false, 'boolean'),
        'topic_id'  => new xmlrpcval($new_topic_id),
        'state'     => new xmlrpcval($is_approved ? 0 : 1, 'int'),
    ), 'struct');

    return new xmlrpcresp($xmlrpc_create_topic);
}

function reply_topic_func()
{
    global $new_post_id, $becomesApproved;

    $xmlrpc_reply_topic = new xmlrpcval(array(
        'result'    => new xmlrpcval($new_post_id ? true : false, 'boolean'),
        'post_id'   => new xmlrpcval($new_post_id),
        'state'     => new xmlrpcval($becomesApproved ? 0 : 1, 'int'),
    ), 'struct');

    return new xmlrpcresp($xmlrpc_reply_topic);
}

function get_raw_post_func()
{
    global $context,$attachments;
    
    $postId = $_GET['msg'];
    $attachments = exttMbqGetAtt($postId);
    $outputAtt = array();
    $groupIds = array();
    foreach($attachments as $attachment)
    {
        $thumb_id = intval($attachment['thumbnail']['id']);
        $extension = pathinfo($attachment['name'], PATHINFO_EXTENSION);
        if(empty($extension))
            $extension = 'other';
        $xmlrpc_attachment = new xmlrpcval(array(
            'attachment_id' => new xmlrpcval($attachment['id'].'.'.$thumb_id),
            'filename'      => new xmlrpcval(basic_clean($attachment['name']), 'base64'),
            'filesize'      => new xmlrpcval($attachment['byte_size'], 'int'),
            'content_type'  => new xmlrpcval($attachment['is_image'] ? 'image' : $extension),
            'thumbnail_url' => new xmlrpcval($attachment['thumbnail']['has_thumb'] ? $attachment['thumbnail']['href'] : ''),
            'url'           => new xmlrpcval($attachment['href'])
        ), 'struct');
        $outputAtt[] = $xmlrpc_attachment;
        $groupIds[$attachment['id']] = $thumb_id;
    }

    $response = array(
        'post_id'       => new xmlrpcval($_GET['msg']),
        'post_title'    => new xmlrpcval(basic_clean($context['subject']), 'base64'),
        'post_content'  => new xmlrpcval(basic_clean($context['message']), 'base64')
    );
    
    if ($outputAtt)
    {
        $response['group_id'] = new xmlrpcval(serialize($groupIds), 'string');
        $response['attachments'] = new xmlrpcval($outputAtt, 'array');
    }

    return new xmlrpcresp(new xmlrpcval($response, 'struct'));
}

function save_raw_post_func()
{
    global $becomesApproved;

    return new xmlrpcresp(
        new xmlrpcval(array(
            'result' => new xmlrpcval(true, 'boolean'),
            'state'  => new xmlrpcval($becomesApproved ? 0 : 1, 'int'),
        ), 'struct'));
}

function get_quote_post_func()
{
    global $context;

    $response = new xmlrpcval(
        array(
            'post_id'       => new xmlrpcval($_GET['quote']),
            'post_title'    => new xmlrpcval(basic_clean($context['subject']), 'base64'),
            'post_content'  => new xmlrpcval(basic_clean($context['message']), 'base64'),
        ),
        'struct'
    );

    return new xmlrpcresp($response);
}

function get_quote_pm_func()
{
    global $context;

    $response = new xmlrpcval(
        array(
            'msg_id'        => new xmlrpcval($_GET['pmsg']),
            'msg_subject'   => new xmlrpcval(basic_clean($context['subject']), 'base64'),
            'text_body'     => new xmlrpcval(basic_clean($context['message']), 'base64'),
        ),
        'struct'
    );

    return new xmlrpcresp($response);
}

function get_inbox_stat_func()
{
    global $context;

    $result = new xmlrpcval(array(
        'inbox_unread_count' => new xmlrpcval($context['inbox_unread_count'], 'int'),
        'subscribed_topic_unread_count' => new xmlrpcval($context['totalUnreadNotifications'], 'int'),
    ), 'struct');

    return new xmlrpcresp($result);
}

function get_box_info_func()
{
    global $context;

    $box_list = array();
    foreach($context['boxes'] as $box)
    {
        $box_list[] = new xmlrpcval(array(
            'box_id'        => new xmlrpcval($box['id'], 'string'),
            'box_name'      => new xmlrpcval(basic_clean($box['name']), 'base64'),
            'msg_count'     => new xmlrpcval($box['msg_count'], 'int'),
            'unread_count'  => new xmlrpcval($box['unread_count'], 'int'),
            'box_type'      => new xmlrpcval($box['box_type'], 'string')
        ), 'struct');
    }

    $result = new xmlrpcval(array(
        'message_room_count' => new xmlrpcval($context['message_remain'], 'int'),
        'list'               => new xmlrpcval($box_list, 'array')
    ), 'struct');

    return new xmlrpcresp($result);
}

function get_box_func()
{
    global $context;

    $pm_list = array();
    foreach ($context['messages'] as $pm)
    {
        $msg_to = array();
        foreach ($pm['recipients']['to'] as $rec_user) {
            $msg_to[] = new xmlrpcval(array(
                'user_id'  => new xmlrpcval(intval(preg_replace('/^.*?;u=(\d+).*?$/si', '$1', $rec_user))),
                'username' => new xmlrpcval(basic_clean($rec_user), 'base64'),
            ), 'struct');
        }
        foreach ($pm['recipients']['bcc'] as $rec_user) {
            $msg_to[] = new xmlrpcval(array(
                'user_id'  => new xmlrpcval(intval(preg_replace('/^.*?;u=(\d+).*?$/si', '$1', $rec_user))),
                'username' => new xmlrpcval(basic_clean($rec_user), 'base64')
            ), 'struct');
        }

        $pm_list[] = new xmlrpcval(array(
            'msg_id'        => new xmlrpcval($pm['id']),
            'msg_state'     => new xmlrpcval($pm['is_unread'] ? 1 : ($pm['is_replied_to'] ? 3 : 2), 'int'),
            'sent_date'     => new xmlrpcval($pm['time'],'dateTime.iso8601'),
            'timestamp'     => new xmlrpcval($pm['timestamp'], 'string'),
            'msg_from'      => new xmlrpcval(basic_clean($pm['msg_from']), 'base64'),
            'msg_from_id'   => new xmlrpcval($pm['msg_from_id']),
            'icon_url'      => new xmlrpcval($pm['member']['avatar']['href']),
            'msg_to'        => new xmlrpcval($msg_to, 'array'),
            'msg_subject'   => new xmlrpcval(basic_clean($pm['subject']), 'base64'),
            'short_content' => new xmlrpcval(basic_clean($pm['body'], 100), 'base64'),
            'is_online'     => new xmlrpcval($pm['member']['online']['is_online'] ? true : false, 'boolean'),
        ), 'struct');
    }

    $result = new xmlrpcval(array(
        'total_message_count' => new xmlrpcval($context['pmnum'], 'int'),
        'total_unread_count'  => new xmlrpcval($context['unread_messages'], 'int'),
        'list'                => new xmlrpcval($pm_list, 'array')
    ), 'struct');

    return new xmlrpcresp($result);
}

function delete_message_func()
{
    return new xmlrpcresp(new xmlrpcval(array('result' => new xmlrpcval(true, 'boolean')), 'struct'));
}

function mark_pm_unread_func()
{
    global $mark_result;
    
    return new xmlrpcresp(new xmlrpcval(array('result' => new xmlrpcval($mark_result, 'boolean')), 'struct'));
}

function get_message_func()
{
    global $context;

    $result = new xmlrpcval(array(
        'msg_from_id'   => new xmlrpcval(basic_clean($context['pm']['id_member'])),
        'msg_from'      => new xmlrpcval(basic_clean($context['pm']['name']), 'base64'),
        'msg_to'        => new xmlrpcval($context['pm']['recipients'], 'array'),
        'icon_url'      => new xmlrpcval($context['pm']['member']['avatar']['href']),
        'sent_date'     => new xmlrpcval($context['pm']['time'],'dateTime.iso8601'),
        'timestamp'     => new xmlrpcval($context['pm']['timestamp'], 'string'),
        'msg_subject'   => new xmlrpcval(basic_clean($context['pm']['subject']), 'base64'),
        'text_body'     => new xmlrpcval(post_html_clean($context['pm']['body']), 'base64'),
        'is_online'     => new xmlrpcval($context['pm']['member']['online']['is_online'] ? true : false, 'boolean'),
        'allow_smilies' => new xmlrpcval(true, 'boolean'),
    ), 'struct');

    return new xmlrpcresp($result);
}

function attach_image_func()
{
    global $context;

    if (isset($context['attachids'][0]))
    {
        $associate_id = implode('.', $context['attachids']);
        $xmlrpc_result = new xmlrpcval(array('attachment_id'  => new xmlrpcval($associate_id)), 'struct');
        return new xmlrpcresp($xmlrpc_result);
    }
    else
    {
        get_error('Add attachment failed!');
    }
}

function search_func()
{
    global $context;
    
    if (!empty($context['search_errors']))
    {
        $result_text = implode("\n", $context['search_errors']['messages']);
        $result = new xmlrpcval(array(
            'result' => new xmlrpcval(false, 'boolean'),
            'result_text' => new xmlrpcval(basic_clean($result_text), 'base64')
        ), 'struct');

        return new xmlrpcresp($result);
    }
    
    //by Post? by Topic?
    //if (!$context['compact'])
    if ((ExttMbqBase::$otherParameters['search_filter']['userid'] || ExttMbqBase::$otherParameters['search_filter']['searchuser']) && !ExttMbqBase::$otherParameters['search_filter']['showposts']) {
         return search_topic_func();
    } elseif (!$context['compact'])
    {
         return search_post_func();
    }
    else
    {
         return search_topic_func();
    }
}

function search_topic_func()
{
    global $context, $smcFunc;

    $topic_list = array();
    if (isset($context['get_topics']))
    {
        while ($topic = $context['get_topics']())
        {
            $topic_info = get_topic_info($topic['board']['id'], $topic['id']);
    
            $xmlrpc_topic = new xmlrpcval(array(
                'forum_id'          => new xmlrpcval($topic['board']['id']),
                'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
                'topic_id'          => new xmlrpcval($topic['id']),
                'post_id'           => new xmlrpcval($topic['matches'][0]['id']),
                'topic_title'       => new xmlrpcval(basic_clean($topic['matches'][0]['subject']), 'base64'),
           'post_author_name'       => new xmlrpcval(basic_clean($topic['matches'][0]['member']['name']), 'base64'),
                'short_content'     => new xmlrpcval(basic_clean($topic['matches'][0]['body'], 0, 1), 'base64'),
                'icon_url'          => new xmlrpcval($topic['matches'][0]['member']['avatar']['href']),
                'post_time'         => new xmlrpcval($topic['matches'][0]['time'], 'dateTime.iso8601'),
                'timestamp'         => new xmlrpcval($topic['matches'][0]['timestamp'], 'string'),
                'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
                'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
                'new_post'          => new xmlrpcval($topic_info['new'], 'boolean'),
                'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'], 'boolean'),
                'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
                'is_sticky'          => new xmlrpcval($topic_info['is_sticky'], 'boolean'),
                'is_closed'         => new xmlrpcval($topic_info['is_locked'], 'boolean'),
    
                'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
                'can_close'         => new xmlrpcval($topic_info['can_lock'], 'boolean'),
                'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
                'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
                'can_rename'        => new xmlrpcval($topic_info['can_move'], 'boolean'),
            ), 'struct');
    
            $topic_list[] = $xmlrpc_topic;
        }
    
        $result = new xmlrpcval(array(
            'total_topic_num' => new xmlrpcval($context['num_results'] == 0 && !empty($topic_list) ? count($topic_list) : $context['num_results'], 'int'),
            'search_id'       => new xmlrpcval($context['params'], 'string'),
            'topics'          => new xmlrpcval($topic_list, 'array')
        ), 'struct');
    } elseif (isset($context['exttMbqRecords'])) {  //search by user
        foreach($context['exttMbqRecords'] as $topic)
        {
            $topic_info = get_topic_info($topic['board']['id'], $topic['topic']);
            
            $mbqResult = $smcFunc['db_query']('', '
                SELECT *
                FROM {db_prefix}messages
                WHERE id_msg = {int:id_msg}',
                array(
                    'id_msg' => $topic['id'],
                )
            );
            $mbqRow = $smcFunc['db_fetch_assoc']($mbqResult);
            require_once(ExttMbqBase::$otherParameters['sourcedir'] . '/Subs-Members.php');
            $member = list_getMembers(0, 10, 'member_name', '(mem.id_member = {int:memberId})', array('memberId' => $mbqRow['id_member']));
            $member = $member[0];
    
            $xmlrpc_topic = new xmlrpcval(array(
                'forum_id'          => new xmlrpcval($topic['board']['id']),
                'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
                'topic_id'          => new xmlrpcval($topic['topic']),
                'post_id'           => new xmlrpcval($topic['id']),
                'topic_title'       => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
           'post_author_name'       => new xmlrpcval(basic_clean($member['member_name']), 'base64'),
                'short_content'     => new xmlrpcval(basic_clean($topic['body'], 0, 1), 'base64'),
                'icon_url'          => new xmlrpcval($topic['matches'][0]['member']['avatar']['href']),
                'post_time'         => new xmlrpcval($topic['time'], 'dateTime.iso8601'),
                'timestamp'         => new xmlrpcval($topic['timestamp'], 'string'),
                'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
                'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
                'new_post'          => new xmlrpcval($topic_info['new'], 'boolean'),
                'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'], 'boolean'),
                'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
                'is_sticky'          => new xmlrpcval($topic_info['is_sticky'], 'boolean'),
                'is_closed'         => new xmlrpcval($topic_info['is_locked'], 'boolean'),
    
                'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
                'can_close'         => new xmlrpcval($topic_info['can_lock'], 'boolean'),
                'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
                'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
                'can_rename'        => new xmlrpcval($topic_info['can_move'], 'boolean'),
            ), 'struct');
    
            $topic_list[] = $xmlrpc_topic;
        }
    
        $result = new xmlrpcval(array(
            'total_topic_num' => new xmlrpcval($context['exttMbqTotal'] == 0 && !empty($topic_list) ? count($topic_list) : $context['exttMbqTotal'], 'int'),
            'search_id'       => new xmlrpcval($context['exttMbqSearchId'], 'string'),
            'topics'          => new xmlrpcval($topic_list, 'array')
        ), 'struct');
    }
    else
        $result = new xmlrpcval(array(
            'total_topic_num' => new xmlrpcval($context['num_results'], 'int'),  ), 'struct');
    return new xmlrpcresp($result);
}

function search_post_func()
{
    global $context, $smcFunc;
    $post_list = array();
    if (isset($context['get_topics']))
    {
        while ($topic = $context['get_topics']())
        {
            $topic_info = get_topic_info($topic['board']['id'], $topic['id']);
    
            $xmlrpc_post = new xmlrpcval(array(
                'forum_id'          => new xmlrpcval($topic['board']['id']),
                'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
                'topic_id'          => new xmlrpcval($topic['id']),
                'topic_title'       => new xmlrpcval(basic_clean($topic['first_post']['subject']), 'base64'),
                'post_id'           => new xmlrpcval($topic['matches'][0]['id'], 'string'),
                'post_title'        => new xmlrpcval(basic_clean($topic['matches'][0]['subject']), 'base64'),
           'post_author_name'       => new xmlrpcval(basic_clean($topic['matches'][0]['member']['name']), 'base64'),
                'short_content'     => new xmlrpcval(basic_clean($topic['matches'][0]['body'], 0, 1), 'base64'),
                'icon_url'          => new xmlrpcval($topic['matches'][0]['member']['avatar']['href']),
                'post_time'         => new xmlrpcval($topic['matches'][0]['time'], 'dateTime.iso8601'),
                'timestamp'         => new xmlrpcval($topic['matches'][0]['timestamp'], 'string'),
                'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
                'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
                'new_post'          => new xmlrpcval($topic_info['new'], 'boolean'),
                'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'], 'boolean'),
                'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
                'is_closed'         => new xmlrpcval($topic_info['is_locked'], 'boolean'),
                'is_sticky'          => new xmlrpcval($topic_info['is_sticky'], 'boolean'),
    
                'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
                'can_close'         => new xmlrpcval($topic_info['can_lock'], 'boolean'),
                'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
                'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
            ), 'struct');
    
            $post_list[] = $xmlrpc_post;
        }
        $result = new xmlrpcval(array(
            'total_post_num' => new xmlrpcval($context['num_results'] == 0 && !empty($post_list) ? count($post_list) : $context['num_results'], 'int'),
            'search_id'       => new xmlrpcval($context['params'], 'string'),
            'posts'          => new xmlrpcval($post_list, 'array')
        ), 'struct');
    } elseif (isset($context['exttMbqRecords'])) {  //search by user
        foreach($context['exttMbqRecords'] as $topic)
        {
            $topic_info = get_topic_info($topic['board']['id'], $topic['topic']);
            
            $mbqResult = $smcFunc['db_query']('', '
                SELECT *
                FROM {db_prefix}messages
                WHERE id_msg = {int:id_msg}',
                array(
                    'id_msg' => $topic['id'],
                )
            );
            $mbqRow = $smcFunc['db_fetch_assoc']($mbqResult);
            require_once(ExttMbqBase::$otherParameters['sourcedir'] . '/Subs-Members.php');
            $member = list_getMembers(0, 10, 'member_name', '(mem.id_member = {int:memberId})', array('memberId' => $mbqRow['id_member']));
            $member = $member[0];
    
            $xmlrpc_post = new xmlrpcval(array(
                'forum_id'          => new xmlrpcval($topic['board']['id']),
                'forum_name'        => new xmlrpcval(basic_clean($topic['board']['name']), 'base64'),
                'topic_id'          => new xmlrpcval($topic['topic']),
                'topic_title'       => new xmlrpcval(basic_clean($topic_info['first_subject']), 'base64'),
                'post_id'           => new xmlrpcval($topic['id'], 'string'),
                'post_title'        => new xmlrpcval(basic_clean($topic['subject']), 'base64'),
           'post_author_name'       => new xmlrpcval(basic_clean($member['member_name']), 'base64'),
                'short_content'     => new xmlrpcval(basic_clean($topic['body'], 0, 1), 'base64'),
                'icon_url'          => new xmlrpcval($topic['matches'][0]['member']['avatar']['href']),
                'post_time'         => new xmlrpcval($topic['time'], 'dateTime.iso8601'),
                'timestamp'         => new xmlrpcval($topic['timestamp'], 'string'),
                'reply_number'      => new xmlrpcval($topic_info['num_replies'], 'int'),
                'view_number'       => new xmlrpcval($topic_info['num_views'], 'int'),
                'new_post'          => new xmlrpcval($topic_info['new'], 'boolean'),
                'can_subscribe'     => new xmlrpcval($topic_info['can_mark_notify'], 'boolean'),
                'is_subscribed'     => new xmlrpcval($topic_info['is_marked_notify'], 'boolean'),
                'is_closed'         => new xmlrpcval($topic_info['is_locked'], 'boolean'),
                'is_sticky'          => new xmlrpcval($topic_info['is_sticky'], 'boolean'),
    
                'can_delete'        => new xmlrpcval($topic_info['can_remove'], 'boolean'),
                'can_close'         => new xmlrpcval($topic_info['can_lock'], 'boolean'),
                'can_stick'         => new xmlrpcval($topic_info['can_sticky'], 'boolean'),
                'can_move'          => new xmlrpcval($topic_info['can_move'], 'boolean'),
            ), 'struct');
    
            $post_list[] = $xmlrpc_post;
        }
        $result = new xmlrpcval(array(
            'total_post_num' => new xmlrpcval($context['exttMbqTotal'] == 0 && !empty($post_list) ? count($post_list) : $context['exttMbqTotal'], 'int'),
            'search_id'       => new xmlrpcval($context['exttMbqSearchId'], 'string'),
            'posts'          => new xmlrpcval($post_list, 'array')
        ), 'struct');
    }
    else
    {
         $result = new xmlrpcval(array(
            'total_post_num' => new xmlrpcval(0, 'int'),
           
        ), 'struct');
    }
    return new xmlrpcresp($result);
}

function xmlresptrue()
{
    global $result_topic_id;
    
    $result = array(
        'result'        => new xmlrpcval(true, 'boolean'),
        'result_text'   => new xmlrpcval('', 'base64')
    );
    
    if (isset($result_topic_id) && $result_topic_id)
    {
        $result['topic_id'] = new xmlrpcval($result_topic_id, 'string');
    }

    return new xmlrpcresp(new xmlrpcval($result, 'struct'));
}

function report_post_func()
{
    return xmlresptrue();
}

function upload_attach_func()
{
    global $attachIDs, $group_id;

    if (!empty($attachIDs)) $group_id[$attachIDs[0]] = isset($attachIDs[1]) ? $attachIDs[1] : '';

    $xmlrpc_result = new xmlrpcval(array(
        'attachment_id' => new xmlrpcval(implode('.', $attachIDs)),
        'group_id'      => new xmlrpcval(serialize($group_id)),
        'result'        => new xmlrpcval(empty($attachIDs) ? false : true, 'boolean'),
    ), 'struct');

    return new xmlrpcresp($xmlrpc_result);
}

function remove_attachment_func()
{
    global $group_id;

    $xmlrpc_result = new xmlrpcval(array(
        'result'        => new xmlrpcval(true, 'boolean'),
        'group_id'      => new xmlrpcval(serialize($group_id)),
    ), 'struct');

    return new xmlrpcresp($xmlrpc_result);
}

function m_get_report_post_func()
{
    global $context, $user_profile, $settings, $scripturl, $modSettings, $smcFunc;;

    $post_list = array();
    foreach($context['reports'] as $post)
    {
        $matches = array();
        preg_match('/topic=(\d+)\.msg(\d+)/i', $post['topic_href'], $matches);

        $request = $smcFunc['db_query']('', '
            SELECT m.id_topic, m.id_board, b.name
            FROM {db_prefix}messages m
                LEFT JOIN {db_prefix}boards AS b ON (m.id_board = b.id_board)
            WHERE m.id_msg = {int:message_id}',
            array(
                'message_id' => $matches[2],
            )
        );

        list ($topic_id, $board_id, $board_name) = $smcFunc['db_fetch_row']($request);

        if (empty($topic_id))
        {
            $context['total_reports']--;
            continue;
        }

        $avatar = '';
        if (!isset($user_profile[$post['author']['id']]))
            loadMemberData($post['author']['id']);
        $profile = $user_profile[$post['author']['id']];
        if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
        {
            $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
        }
        
        $requestDetail = $smcFunc['db_query']('', '
            SELECT d.*
            FROM {db_prefix}log_reported_comments d, {db_prefix}log_reported r
            WHERE d.id_report = r.id_report and r.id_topic = {int:id_topic} and r.id_msg = {int:id_msg} 
            ORDER BY d.time_sent DESC LIMIT 1',
            array(
                'id_topic' => $topic_id,
                'id_msg' => $matches[2]
            )
        );
        $rDeatil = $smcFunc['db_fetch_assoc']($requestDetail);
        $smcFunc['db_free_result']($requestDetail);
        
        $post_list[] = new xmlrpcval(array(
            'forum_id'          => new xmlrpcval($board_id),
            'forum_name'        => new xmlrpcval(basic_clean($board_name), 'base64'),
            'topic_id'          => new xmlrpcval($topic_id),
            'topic_title'       => new xmlrpcval(basic_clean($post['subject']), 'base64'),
            'post_id'           => new xmlrpcval($matches[2]),
            'post_title'        => new xmlrpcval(basic_clean($post['subject']), 'base64'),
            'post_author_name'  => new xmlrpcval(basic_clean($post['author']['name']), 'base64'),
            'post_author_id'    => new xmlrpcval(basic_clean($post['author']['id']), 'string'),
            'icon_url'          => new xmlrpcval($avatar),
            'post_time'         => new xmlrpcval($post['time_started'], 'dateTime.iso8601'),
            'timestamp'         => new xmlrpcval($post['timestamp_started'], 'string'),
            'short_content'     => new xmlrpcval(basic_clean($post['body'], 100, 1), 'base64'),
            'can_delete'        => new xmlrpcval(allowedTo('delete_any'), 'boolean'),
            'reported_by_id'          => new xmlrpcval($rDeatil['id_member']),
            'reported_by_name'  => new xmlrpcval(basic_clean($rDeatil['membername']), 'base64'),
            'report_reason'  => new xmlrpcval(basic_clean($rDeatil['comment']), 'base64'),
        ), 'struct');

        unset($topic_id, $board_id, $request);
    }

    $response = new xmlrpcval(
        array(
            'total_report_num' => new xmlrpcval($context['total_reports'], 'int'),
            'reports'          => new xmlrpcval($post_list, 'array'),
        ), 'struct'
    );

    return new xmlrpcresp($response);
}

function update_push_status_func()
{
    global $user_info, $smcFunc, $boardurl, $modSettings, $request_params;
    
    $status = false;
    if ($user_info['id'])
    {
        $data = array(
            'url'  => $boardurl,
            'key'  => isset($modSettings['tp_push_key']) && !empty($modSettings['tp_push_key']) ? $modSettings['tp_push_key'] : '',
            'uid'  => $user_info['id'],
            'data' => base64_encode(serialize($request_params[0])),
        );
        $url = 'https://directory.tapatalk.com/au_update_push_setting.php';
        getContentFromRemoteServer($url, 0, $error_msg, 'POST', $data);
        $status = true;
    }
    $result = new xmlrpcval(array(
            'result'        => new xmlrpcval($status, 'boolean')),
        'struct');
    return new xmlrpcresp($result); 
}


function get_alert_func()
{
    global $user_info, $smcFunc, $user_profile, $scripturl, $modSettings, $settings;

    $alert_format = array(
        'sub'       => '%s replied to "%s"',
        'like'      => '%s liked your post in thread "%s"',
        'thank'     => '%s thanked your post in thread "%s"',
        'quote'     => '%s quoted your post in thread "%s"',
        'tag'       => '%s mentioned you in thread "%s"',
        'newtopic'  => '%s started a new thread "%s"',
        'pm'        => '%s sent you a message "%s"',
        'ann'       => '%sNew Announcement "%s"',
    );

    $start = ($_POST['page']-1)*$_POST['perpage'];
    $current_userid = $user_info['id'];
    if($current_userid == 0)
        return new xmlrpcresp(new xmlrpcval(array(
            'result'        => new xmlrpcval(false, 'boolean'),
            'result_text'   => new xmlrpcval("You should loggin to do that!", 'base64'),
        )));

    $alerts = array();
    $request = $smcFunc['db_query']('', '
        SELECT * FROM {db_prefix}tapatalk_push
        WHERE userid = {int:current_userid} ORDER BY dateline DESC LIMIT {int:start}, {int:perpage}',
        array(
            'current_userid' => $current_userid,
            'start'          => $start,
            'perpage'        => $_POST['perpage']
        )
    );
    while ($result = $smcFunc['db_fetch_assoc']($request))
    {
        if (!isset($alert_format[$result['type']])) continue;

        $message = sprintf($alert_format[$result['type']], $result['author'], mobiquo_encode($result['title']));
        $userids = loadMemberData($result['author'], true);
        $userid = is_array($userids)? $userids[0] : $userids;
        $profile = $user_profile[$userid];
        if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
        {
            $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
        }
        $alert = array(
            'user_id'       => new xmlrpcval($userid, 'string'),
            'username'      => new xmlrpcval($result['author'], 'base64'),
            'icon_url'      => new xmlrpcval($avatar, 'string'),
            'message'       => new xmlrpcval($message, 'base64'),
            'timestamp'     => new xmlrpcval($result['dateline'], 'string'),
            'content_type'  => new xmlrpcval($result['type'], 'string'),
            'content_id'    => new xmlrpcval($result['type'] == 'pm' ? $result['id'] : $result['subid'], 'string'),
        );
        if (($result['type'] == 'sub') || ($result['type'] == 'like') || ($result['type'] == 'thank') || ($result['type'] == 'quote') || ($result['type'] == 'tag') || ($result['type'] == 'newtopic')) {
            $alert['topic_id'] = new xmlrpcval($result['id'], 'string');
        }
        $alerts[] = new xmlrpcval($alert, 'struct');
    }
    $total_num = count($alerts);
    $return_data = array(
        'total' => new xmlrpcval($total_num, 'int'),
        'items' => new xmlrpcval($alerts, 'array')
    );
    return new xmlrpcresp(new xmlrpcval($return_data, 'struct'));
}

function register_func()
{
    global $context, $modSettings, $txt;
    
    $status = empty($modSettings['registration_method']) ? 'nothing' : ($_POST['emailActivate'] ? ($modSettings['registration_method'] == 1 ? 'activation' : 'approval') : 'nothing');
    if($status == 'activation')
        $result_text = isset($txt['activate_after_registration'])? $txt['activate_after_registration'] : 'Thank you for registering. You will receive an email soon with a link to activate your account.  If you don\'t receive an email after some time, check your spam folder.';
    else if($status == 'approval'){
        $result_text = isset($txt['approval_after_registration'])? $txt['approval_after_registration'] : 'Thank you for registering. The admin must approve your registration before you may begin to use your account, you will receive an email shortly advising you of the admins decision.';
    }
    $result = new xmlrpcval(array(
            'result'        => new xmlrpcval(isset($context['registration_done']), 'boolean'),
            'result_text'   => new xmlrpcval($result_text, 'base64')),
        'struct');
    return new xmlrpcresp($result);
}

function sign_in_func()
{
    global $context, $modSettings, $txt;
    
    
    if($_POST['action'] == 'login2') return login_func();
    if($_POST['action'] == 'register') return register_func();

    $result = new xmlrpcval(array(
            'result'        => new xmlrpcval(isset($context['registration_done']), 'boolean'),
            'result_text'   => new xmlrpcval($result_text, 'base64')),
        'struct');
    return new xmlrpcresp($result);
}

function update_password_func()
{
    global $context;

        $result = new xmlrpcval(array(
            'result'        => new xmlrpcval(1, 'boolean'),
            'result_text'   => new xmlrpcval('', 'base64')),
        'struct');
    return new xmlrpcresp($result);
}

function update_email_func()
{
    global $context, $txt;

    $result_text = '';
    if(isset($context['post_errors']) && !empty($context['post_errors']))
        foreach($context['post_errors'] as $error)
        {
            $result_text .= $error;
            if(isset($txt['profile_error_'.$error]))
                fatal_lang_error('profile_error_'.$error);
            }

     $result = new xmlrpcval(array(
        'result'        => new xmlrpcval(1, 'boolean'),
        'result_text'   => new xmlrpcval($result_text, 'base64')),
    'struct');
    return new xmlrpcresp($result);
}

function forget_password_func()
{
    $result = array(
        'result'        => new xmlrpcval(isset($_POST['result']) ? $_POST['result'] : 1, 'boolean'),
        'verified'      => new xmlrpcval(isset($_POST['verified'])? $_POST['verified'] : false, 'boolean'));

    if(isset($_POST['result_text']) && !empty($_POST['result_text']))
        $result['result_text'] = new xmlrpcval($_POST['result_text'], 'base64');

    return new xmlrpcresp(new xmlrpcval($result, 'struct'));
}

function prefetch_account_func()
{
    global $context, $user_profile, $settings, $scripturl, $modSettings;

    if(empty($_REQUEST['u']))
        return get_error();
    loadMemberData($_REQUEST['u']);
    $profile = $user_profile[$_REQUEST['u']];
    if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
        $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
    else
        $avatar = '';
    $result = new xmlrpcval(array(
        'result'        => new xmlrpcval(true, 'boolean'),
        'user_id'         => new xmlrpcval($user_profile[$_REQUEST['u']]['id_member'], 'string'),
        'login_name'        => new xmlrpcval(basic_clean($user_profile[$_REQUEST['u']]['member_name']), 'base64'),
        'display_name'        => new xmlrpcval(basic_clean($user_profile[$_REQUEST['u']]['real_name']), 'base64'),
        'avatar'                => new xmlrpcval($avatar, 'string'),
    ), 'struct');
    
    return new xmlrpcresp($result);
}

function search_user_func()
{
    global $user_lists;
    
    $page = (empty($_POST['page']) || $_POST['page'] < 0 )? 1 : $_POST['page'];
    $perpage = (empty($_POST['perpage']) || $_POST['perpage'] < 0)? 20 : $_POST['perpage'];
    $start = ($page - 1)*$perpage;
    $limit = $page * $perpage;
    
    $total = count($user_lists);
    $return_user_lists = array();

    
    if(!empty($user_lists))
    {
        $count = 0;
        foreach ($user_lists as $user)
        {
            if(($count > $start -1) && ($count < $limit))
            $return_user_lists[] = new xmlrpcval(array(
                'user_name'     => new xmlrpcval($user['username'], 'base64'),
                'user_id'       => new xmlrpcval($user['userid'], 'string'),
                'icon_url'      => new xmlrpcval($user['icon_url'], 'string'),
            ), 'struct');
            $count ++;
        }
    }
    $suggested_users = new xmlrpcval(array(
        'total' => new xmlrpcval($total, 'int'),
        'list'         => new xmlrpcval($return_user_lists, 'array'),
    ), 'struct');
    
    
    return new xmlrpcresp($suggested_users);
}

function ignore_user_func()
{
    return xmlresptrue();
    
}

function get_recommended_user_func()
{
    global $context, $smcFunc, $user_info, $profile, $user_profile, $settings, $scripturl;

    $mobi_api_key = loadAPIKey();
    $user_id = $user_info['id'];

    if(!empty($mobi_api_key) && !empty($user_id))
    {
        $return_user_lists = array();
        $total = 0;
        $user_lists = $context['recommend'];
        $start = $_REQUEST['start'];
        $end = $_REQUEST['end'];
        $return_user_lists = array();
        if(isset($user_lists[$user_id])) unset($user_lists[$user_id]);
        
        if(!empty($user_lists))
        {
            if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 2)
            {
                $check_users = array_keys($user_lists);
                $valid_users_result = $smcFunc['db_query']('', '
                    SELECT *
                    FROM {db_prefix}tapatalk_users 
                    WHERE userid IN ({array_int:check_users})',
                    array(
                        'check_users' => $check_users
                    )
                );
                
                while ($tapausers = $smcFunc['db_fetch_assoc']($valid_users_result))
                {
                    unset($user_lists[$tapausers['userid']]);
                }
                if($is_tapa_user) continue;
            }
            $total = count($user_lists);
            arsort($user_lists);
            $num_track = 0;
            foreach ($user_lists as $uid => $score)
            {
                if($num_track > $start - 1 && $num_track < $end)
                {
                    loadMemberData($uid);
                    $profile = $user_profile[$uid];
                    if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
                    {
                        $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
                    }
                    else
                        $avatar = '';
                    if(!empty($profile))
                    {
                        $return_user_lists[] = new xmlrpcval(array(
                            'username'   => new xmlrpcval(basic_clean($user_profile[$uid]['member_name']), 'base64'),
                            'user_id'    => new xmlrpcval($user_profile[$uid]['id_member'], 'string'),
                            'icon_url'   => new xmlrpcval($avatar, 'string'),
                            'enc_email'  => new xmlrpcval(base64_encode(encrypt(trim($profile['email_address']), $mobi_api_key)), 'string'),
                        ), 'struct');
                    }
                    $num_track ++;
                }
            }
        }
    }

    $suggested_users = new xmlrpcval(array(
        'total' => new xmlrpcval($total, 'int'),
        'list'  => new xmlrpcval($return_user_lists, 'array'),
    ), 'struct');

    return new xmlrpcresp($suggested_users);
}

function get_contact_func()
{
    global $user_profile;
    
    $mobi_api_key = loadAPIKey();
    $user_id = $_POST['uid'];
    
    $result = array(
        'result' => new xmlrpcval(false, 'boolean'),
    );
    
    if(!empty($mobi_api_key) && !empty($user_id))
    {
        loadMemberData($user_id, false, 'profile');
        $profile = $user_profile[$user_id];
        
        if($profile && $profile['notify_announcements'])
        {
            $result = array(
                'result'        => new xmlrpcval(true, 'boolean'),
                'user_id'       => new xmlrpcval($profile['id_member']),
                'display_name'  => new xmlrpcval(basic_clean($profile['real_name']), 'base64'),
                'enc_email'     => new xmlrpcval(base64_encode(encrypt(trim($profile['email_address']), $mobi_api_key))),
            );
        }
    }
    
    return new xmlrpcresp(new xmlrpcval($result, 'struct'));
}
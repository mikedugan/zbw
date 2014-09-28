<?php

defined('IN_MOBIQUO') or exit;

function action_get_config(){}

function action_get_forum()
{
    global $modSettings, $user_info, $context, $smcFunc;
    
    $forum_id_active = isset($_GET['forum_id']) && (!empty($_GET['forum_id']) || $_GET['forum_id'] === '0');
    $query_array = array(
        'current_member' => $user_info['id'],
    );
    if  ($forum_id_active)
    {
        if (strpos($_GET['forum_id'],"c") === 0)
        {   
            $query_condition = " AND b.id_cat = {int:current_cat} AND b.id_parent = {int:current_parent}";
            $query_array['current_cat'] = substr($_GET['forum_id'],1);
            $query_array['current_parent'] = '0';

        }
        else
        {
            $query_condition = " AND b.id_parent = {int:current_parent}";
            $query_array['current_parent'] = $_GET['forum_id'];
        }
    }
    else
    {
        $query_condition = '';
    }
    // Find all the boards this user is allowed to see.
    $request = $smcFunc['db_query']('order_by_board_order', '
        SELECT b.id_cat, c.name AS cat_name, b.id_board, b.name, b.id_parent, b.description, b.redirect,
               IFNULL(mem.member_name, m.poster_name) AS poster_name, '.
               ($user_info['is_guest'] ? ' 1 AS is_read' : '(IFNULL(lb.id_msg, 0) >= b.id_msg_updated) AS is_read').'
        FROM {db_prefix}boards AS b
            LEFT JOIN {db_prefix}categories AS c ON (c.id_cat = b.id_cat)
            LEFT JOIN {db_prefix}messages AS m ON (m.id_msg = b.id_last_msg)
            LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = m.id_member)' . ($user_info['is_guest'] ? '' : '
            LEFT JOIN {db_prefix}log_boards AS lb ON (lb.id_board = b.id_board AND lb.id_member = {int:current_member})').'
        WHERE {query_see_board}'.$query_condition,
    $query_array
    );
   
    $cats = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        if ($forum_id_active)
        {
            $child_request = $smcFunc['db_query']('order_by_board_order', '
                    SELECT id_board, id_cat
                    FROM {db_prefix}boards AS b
                    WHERE {query_see_board}  AND b.id_parent = {int:parent_board}',
                array(
                    'parent_board' => $row['id_board'],
                )
              );
            $child_row = $smcFunc['db_fetch_assoc']($child_request);
            $cats['boards'][$row['id_board']] = array(
                    'id'            => $row['id_board'],
                    'name'          => $row['cat_name'],
                    'description'   => $row['description'],
                    'id_parent'     => strpos($_GET['forum_id'],"c") === 0 ? 'c'.$row['id_cat'] : $row['id_parent'],
                    'redirect'      => '',
                    'new'           => false,
                    'children_new'  => false,
                    'has_child'     => !empty($child_row)
            );
        }
        else
        {
            // This category hasn't been set up yet..
            if (!isset($cats[$row['id_cat']]))
                $cats[$row['id_cat']] = array(
                    'id'            => 'c' . $row['id_cat'],
                    'name'          => $row['cat_name'],
                    'description'   => '',
                    'id_parent'     => -1,
                    'redirect'      => '',
                    'new'           => false,
                    'children_new'  => false
                );
    
            // If this board has new posts in it (and isn't the recycle bin!) then the category is new.
            if (empty($modSettings['recycle_enable']) || $modSettings['recycle_board'] != $row['id_board'])
                $cats[$row['id_cat']]['new'] |= empty($row['is_read']) && $row['poster_name'] != '';
    
            // Set this board up
            $cats[$row['id_cat']]['boards'][$row['id_board']] = array(
                'id'           => $row['id_board'],
                'name'         => $row['name'],
                'description'  => $row['description'],
                'id_parent'    => $row['id_parent'],
                'id_cat'       => $row['id_cat'],
                'redirect'     => $row['redirect'],
                'new'          => empty($row['is_read']) && $row['poster_name'] != '',
                'children_new' => false
            );
    
            if ($row['id_parent'])
                $cats[$row['id_cat']]['boards'][$row['id_parent']]['children_new'] |= empty($row['is_read']) && $row['poster_name'] != '';
        }
    }
    $smcFunc['db_free_result']($request);
    if(!$forum_id_active)
    {
        // Load up the tree
        foreach ($cats as $id_cat => $cat_data)
            foreach ($cat_data['boards'] as $id_board => $board_data)
                if (!empty($board_data['id_parent']))
                    $cats[$id_cat]['boards'][$board_data['id_parent']]['boards'][$id_board] = &$cats[$id_cat]['boards'][$id_board];
    
        // Only add the base item to this array
        foreach ($cats as $id_cat => $cat_data)
            foreach ($cat_data['boards'] as $id_board => $board_data)
                if (!empty($board_data['id_parent']))
                    unset($cats[$id_cat]['boards'][$id_board]);
    }
    $context['forum_tree'] = build_board($forum_id_active ? $cats['boards'] : $cats, true);
}

function action_get_board_stat()
{
    global $context, $sourcedir;
    // Get the user online list.
    require_once($sourcedir . '/Subs-MembersOnline.php');
    $membersOnlineOptions = array(
        'show_hidden' => allowedTo('moderate_forum'),
        'sort' => 'log_time',
        'reverse_sort' => true,
    );
    $context += getMembersOnlineStats($membersOnlineOptions);
}

function build_board($boards, $is_cat = false)
{
    global $settings, $context, $user_info, $smcFunc, $boardurl, $boarddir;
    $response = array();
    foreach ($boards as $id => $board)
    {
        if(empty($board['id'])) continue;
        $new_post = false;
        if ($board['new'] || $board['children_new']) {
            $new_post = true;
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'on'.($board['new'] ? '' : '2').'.png';
        }
        elseif ($board['redirect'])
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'redirect.png';
        else
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'off.png';

        $logo_dir = str_replace($boardurl, $boarddir, $logo_url);
        if (!file_exists($logo_dir) && file_exists(preg_replace('/png$/', 'gif', $logo_dir))) {
            $logo_url = preg_replace('/png$/', 'gif', $logo_url);
        }
        if (!$is_cat && !$user_info['is_guest'] && allowedTo('mark_notify', $board['id'])) {
            $can_subscribe = true;
            $request = $smcFunc['db_query']('', '
                SELECT sent
                FROM {db_prefix}log_notify
                WHERE id_board = {int:current_board}
                    AND id_member = {int:current_member}
                LIMIT 1',
                array(
                    'current_board' => $board['id'],
                    'current_member' => $user_info['id'],
                )
            );
            $is_subscribed = $smcFunc['db_num_rows']($request) != 0;
            $smcFunc['db_free_result']($request);
        } else {
            $can_subscribe = false;
            $is_subscribed = false;
        }

        $is_link_forum = isset($board['redirect']) && !empty($board['redirect']);
        $tp_board_id = $is_cat ? preg_replace('/c/', '', $board['id']): $board['id'];
        $logo_url =  ($tp_logo_url = tp_get_forum_icon($tp_board_id,$is_link_forum ? 'link' : ($is_cat ? 'category' : 'forum'), false, $new_post) )? $tp_logo_url : $logo_url;
        $xmlrpc_forum = array(
            'forum_id'      => new xmlrpcval($board['id'], 'string'),
            'forum_name'    => new xmlrpcval(basic_clean($board['name']), 'base64'),
            'parent_id'     => new xmlrpcval($board['id_parent'] ? $board['id_parent'] : 'c'.$board['id_cat'], 'string'),
            'logo_url'      => new xmlrpcval($logo_url, 'string'),
            'new_post'      => new xmlrpcval($new_post, 'boolean'),
            'url'           => new xmlrpcval($board['redirect'], 'string'),
            'sub_only'      => new xmlrpcval($is_cat, 'boolean'),
            'can_subscribe' => new xmlrpcval($can_subscribe, 'boolean'),
            'is_subscribed' => new xmlrpcval($is_subscribed, 'boolean'),
            'is_protected'  => new xmlrpcval(false, 'boolean'),
        );
        
        if ($_GET['return_description'])
        {
            $xmlrpc_forum['description'] = new xmlrpcval(basic_clean($board['description']), 'base64');
        }
        
        if (isset($_GET['forum_id']) && (!empty($_GET['forum_id']) || $_GET['forum_id'] === 0))
        {
            $xmlrpc_forum['has_child'] = new xmlrpcval($board['has_child'], 'boolean');
        }
        
        if (isset($board['boards']) && !empty($board['boards']))
        {
            $xmlrpc_forum['child'] = new xmlrpcval(build_board($board['boards']), 'array');
        }

        $response[] = new xmlrpcval($xmlrpc_forum, 'struct');
    }

    return $response;
}

function before_action_report_post()
{
    if(!$GLOBALS['context']['user']['is_logged'])
        unset($_REQUEST['action']);
}

function action_report_post()
{
}

function before_action_get_topic()
{
    global $modSettings, $board, $context, $board_info, $user_info, $smcFunc, $topic_per_page, $mode, $start_num;

    $board_info['sticky_num'] = 0;
    $board_info['unread_sticky_num'] = 0;
    if (!empty($modSettings['enableStickyTopics']))
    {
        // Find the number of sticky topic
        $request = $smcFunc['db_query']('', '
            SELECT t.id_topic, ' . ($user_info['is_guest'] ? '0' : 'IFNULL(lt.id_msg, IFNULL(lmr.id_msg, -1)) + 1') . ' AS new_from, ml.id_msg_modified
            FROM {db_prefix}topics AS t
                INNER JOIN {db_prefix}messages AS ml ON (ml.id_msg = t.id_last_msg) ' . ($user_info['is_guest'] ? '' : '
                LEFT JOIN {db_prefix}log_topics AS lt ON (lt.id_topic = t.id_topic AND lt.id_member = {int:current_member})
                LEFT JOIN {db_prefix}log_mark_read AS lmr ON (lmr.id_board = {int:current_board} AND lmr.id_member = {int:current_member})'). '
            WHERE t.id_board = {int:current_board} AND t.is_sticky = {int:is_sticky}' . (!$modSettings['postmod_active'] || allowedTo('approve_posts') ? '' : '
                AND (t.approved = {int:is_approved}' . ($user_info['is_guest'] ? '' : ' OR t.id_member_started = {int:current_member}') . ')'),
            array(
                'current_board' => $board,
                'current_member' => $user_info['id'],
                'is_approved'   => 1,
                'is_sticky'     => 1,
            )
        );

        while ($row = $smcFunc['db_fetch_assoc']($request))
        {
            if ($row['new_from'] <= $row['id_msg_modified']) $board_info['unread_sticky_num']++;
            $board_info['sticky_num']++;
        }
        $smcFunc['db_free_result']($request);
    }

    $context['num_allowed_attachments'] = empty($modSettings['attachmentNumPerPostLimit']) ? 50 : $modSettings['attachmentNumPerPostLimit'];
    $context['can_post_attachment'] = !empty($modSettings['attachmentEnable']) && $modSettings['attachmentEnable'] == 1 && (allowedTo('post_attachment') || ($modSettings['postmod_active'] && allowedTo('post_unapproved_attachments'))) && $context['num_allowed_attachments'] > 0;

    $modSettings['enableStickyTopics_old'] = $modSettings['enableStickyTopics'];

    if ($mode == 'TOP')
    {
        if ($board_info['sticky_num'] == 0)
        {
            $context['can_post_new'] = allowedTo('post_new') || ($modSettings['postmod_active'] && allowedTo('post_unapproved_topics'));
            $context['topics'] = array();
            $_REQUEST['action'] = 'get_sticky_topic';
        }

        $_REQUEST['start'] = 0;
        $modSettings['defaultMaxTopics'] = $board_info['sticky_num'];
    } else {
        $modSettings['enableStickyTopics'] = 0;
        $_REQUEST['start'] = $start_num;
        $modSettings['defaultMaxTopics'] = $topic_per_page;
    }
    before_action_get_thread();
}

function before_action_get_unread_topic()
{
    global $modSettings, $context;
    
    if (empty($context['load_average']) || empty($modSettings['loadavg_allunread']) || $context['load_average'] < $modSettings['loadavg_allunread'])
    {
        $_GET['all'] = 1;
    }
}

function action_get_topic(){}

// Callback for the message display.
function get_post_detail($reset = false)
{
    global $settings, $txt, $modSettings, $scripturl, $options, $user_info, $smcFunc, $sourcedir;
    global $memberContext, $context, $messages_request, $topic, $attachments, $topicinfo;

    static $counter = null;

    // If the query returned false, bail.
    if ($messages_request == false)
        return false;

    // Remember which message this is.  (ie. reply #83)
    if ($counter === null || $reset)
        $counter = empty($options['view_newest_first']) ? $context['start'] : $context['total_visible_posts'] - $context['start'];

    // Start from the beginning...
    if ($reset)
        return @$smcFunc['db_data_seek']($messages_request, 0);

    // Attempt to get the next message.
    $message = $smcFunc['db_fetch_assoc']($messages_request);
    if (!$message)
    {
        $smcFunc['db_free_result']($messages_request);
        return false;
    }

    // $context['icon_sources'] says where each icon should come from - here we set up the ones which will always exist!
    if (empty($context['icon_sources']))
    {
        $stable_icons = array('xx', 'thumbup', 'thumbdown', 'exclamation', 'question', 'lamp', 'smiley', 'angry', 'cheesy', 'grin', 'sad', 'wink', 'moved', 'recycled', 'wireless', 'clip');
        $context['icon_sources'] = array();
        foreach ($stable_icons as $icon)
            $context['icon_sources'][$icon] = 'images_url';
    }

    // Message Icon Management... check the images exist.
    if (empty($modSettings['messageIconChecks_disable']))
    {
        // If the current icon isn't known, then we need to do something...
        if (!isset($context['icon_sources'][$message['icon']]))
            $context['icon_sources'][$message['icon']] = file_exists($settings['theme_dir'] . '/images/post/' . $message['icon'] . '.gif') ? 'images_url' : 'default_images_url';
    }
    elseif (!isset($context['icon_sources'][$message['icon']]))
        $context['icon_sources'][$message['icon']] = 'images_url';

    // If you're a lazy bum, you probably didn't give a subject...
    $message['subject'] = $message['subject'] != '' ? $message['subject'] : $txt['no_subject'];

    // Are you allowed to remove at least a single reply?
    $context['can_remove_post'] |= allowedTo('delete_own') && (empty($modSettings['edit_disable_time']) || $message['poster_time'] + $modSettings['edit_disable_time'] * 60 >= time()) && $message['id_member'] == $user_info['id'];

    // If it couldn't load, or the user was a guest.... someday may be done with a guest table.
    if (!loadMemberContext($message['id_member'], true))
    {
        // Notice this information isn't used anywhere else....
        $memberContext[$message['id_member']]['name'] = $message['poster_name'];
        $memberContext[$message['id_member']]['id'] = 0;
        $memberContext[$message['id_member']]['group'] = $txt['guest_title'];
        $memberContext[$message['id_member']]['link'] = $message['poster_name'];
        $memberContext[$message['id_member']]['email'] = $message['poster_email'];
        $memberContext[$message['id_member']]['show_email'] = showEmailAddress(true, 0);
        $memberContext[$message['id_member']]['is_guest'] = true;
    }
    else
    {
        $memberContext[$message['id_member']]['can_view_profile'] = allowedTo('profile_view_any') || ($message['id_member'] == $user_info['id'] && allowedTo('profile_view_own'));
        $memberContext[$message['id_member']]['is_topic_starter'] = $message['id_member'] == $context['topic_starter_id'];
        $memberContext[$message['id_member']]['can_see_warning'] = !isset($context['disabled_fields']['warning_status']) && $memberContext[$message['id_member']]['warning_status'] && (($context['user']['can_mod'] || !empty($modSettings['warning_show'])) || ($memberContext[$message['id_member']]['id'] == $context['user']['id'] && !empty($modSettings['warning_show']) && $modSettings['warning_show'] == 1));
    }

    $memberContext[$message['id_member']]['ip'] = $message['poster_ip'];

    // Do the censor thang.
    censorText($message['body']);
    censorText($message['subject']);
    // Run BBC interpreter on the message.
    $message['body'] = mobiquo_parse_bbc($message['body'], 0, $message['id_msg']);
    // Compose the memory eat- I mean message array.
    $output = array(
        'smileys_enabled' => $message['smileys_enabled'],
        'attachment' => loadAttachmentContext($message['id_msg']),
        'alternate' => $counter % 2,
        'id' => $message['id_msg'],
        'href' => $scripturl . '?topic=' . $topic . '.msg' . $message['id_msg'] . '#msg' . $message['id_msg'],
        'link' => '<a href="' . $scripturl . '?topic=' . $topic . '.msg' . $message['id_msg'] . '#msg' . $message['id_msg'] . '" rel="nofollow">' . $message['subject'] . '</a>',
        'member' => &$memberContext[$message['id_member']],
        'icon' => $message['icon'],
        'icon_url' => $settings[$context['icon_sources'][$message['icon']]] . '/post/' . $message['icon'] . '.gif',
        'subject' => $message['subject'],
        'time' => timeformat($message['poster_time']),
        'timestamp' => forum_time(true, $message['poster_time']),
        'counter' => $counter,
        'modified' => array(
            'time' => timeformat($message['modified_time']),
            'timestamp' => forum_time(true, $message['modified_time']),
            'name' => $message['modified_name']
        ),
        'body' => $message['body'],
        'new' => empty($message['is_read']),
        'approved' => $message['approved'],
        'first_new' => isset($context['start_from']) && $context['start_from'] == $counter,
        'is_ignored' => !empty($modSettings['enable_buddylist']) && !empty($options['posts_apply_ignore_list']) && in_array($message['id_member'], $context['user']['ignoreusers']),
        'can_approve' => !$message['approved'] && $context['can_approve'],
        'can_unapprove' => $message['approved'] && $context['can_approve'],
        'can_modify' => (!$context['is_locked'] || allowedTo('moderate_board')) && (allowedTo('modify_any') || (allowedTo('modify_replies') && $context['user']['started']) || (allowedTo('modify_own') && $message['id_member'] == $user_info['id'] && (empty($modSettings['edit_disable_time']) || !$message['approved'] || $message['poster_time'] + $modSettings['edit_disable_time'] * 60 > time()))),
        'can_remove' => allowedTo('delete_any') || (allowedTo('delete_replies') && $context['user']['started']) || (allowedTo('delete_own') && $message['id_member'] == $user_info['id'] && (empty($modSettings['edit_disable_time']) || $message['poster_time'] + $modSettings['edit_disable_time'] * 60 > time())),
        'can_see_ip' => allowedTo('moderate_forum') || ($message['id_member'] == $user_info['id'] && !empty($user_info['id'])),
    );

    // Is this user the message author?
    $output['is_message_author'] = $message['id_member'] == $user_info['id'];

    if (empty($options['view_newest_first']))
        $counter++;
    else
        $counter--;

    $installed_mode = mobi_loadInstalledPackages();
    $is_attachments_in_message_mode_installed = false;
    if(!empty($installed_mode))
        foreach($installed_mode as $mode_index => $mode)
            if($mode['name'] == 'Attachments In Message')
            {
                $is_attachments_in_message_mode_installed = true;
                break;
            }
    if($is_attachments_in_message_mode_installed)
    {
        //---------------------------------------------------------------------------    
        // ATTACHMENT IN MESSAGE MOD BEGINS
        // Scan for inlined attachments
      
      // OPTIONS:
      $attachalwaysfullsize = false;    
      
      // start by zeroing out the array keeping track of which attachments have been inlined
      $attachmentreferences = array();
      $context['inlinedimages'] = array();
    
      // now we are going to loop through $message['body'] and search for attachments
      // they are pseudocode of the form [attach=#] or [attachthumb=#] or [attachurl=#] or [attachimg=#]
      $startsearchpos=0;
      $lastinlineattachnum=0;
      while (true)
          {
          // get next [attach*] tag
          $startpos = strpos($output['body'],'[attach',$startsearchpos);
          if ($startpos===false)
              {
              // no more
              break;
              }
          $endpos = strpos($output['body'],']',$startpos);
          if ($endpos==false)
              {
              // no close bracket
              break;
              }
    
          // we got a tag, now figure out where it is and its extent
          $taglen=($endpos-$startpos)-1;
    
          // ok now to be nice, lets see if we are inside a code block and should therefore NOT expand this
          // i put this in a conditional on case you want to disable it for speed
          // maybe there is a faster and better way to do this? this actually can miss some recursive divs but
          // worst case scenario is simply that it will try to inline, wont cause any parsing troubles, etc.        
                $leftmsg=substr($output['body'],0,$startpos);            
                // get last pos (we do it manually since php4 does not support strrpos)
                //$codetaglast = strrpos($leftmsg,'<div class="code">');
                $codetaglast = false;
                $lastpos = 0;
                while (($lastpos=strpos($leftmsg,'<div class="code">',$lastpos))!==false)
                    {
                    $codetaglast = $lastpos;
                    $lastpos = $lastpos + 18;
                    }
                // if there is a class code before us, then see if there is a likely matching end
                if ($codetaglast !== false)
                    {
                    $codetaglastend = strpos($leftmsg,'</div>',$codetaglast);
                    if ($codetaglastend === false)
                        {
                        // skip it
                        $startsearchpos = $endpos+1;
                        continue;
                        }
                    }
    
          // grab the tag
          $tagstring=substr($output['body'],$startpos+1,$taglen);
          $equalpos = strpos($tagstring,'=');
          if ($equalpos>0)
              {
              // separate tag string into keyword and attachment index
              $tagkeyword=substr($tagstring,0,$equalpos);
              $inlineattachnum=substr($tagstring,$equalpos+1);
              }
          else
              {
              $inlineattachnum="";
              $tagkeyword=$tagstring;
              }
    
          // trim keywords and lowercase
          $tagkeyword = strtolower(trim($tagkeyword));
          $inlineattachnum = strtolower(trim($inlineattachnum));
    
          // fixup if they started their attachment # with #
          if (strlen($inlineattachnum)>0)
              {
              if (substr($inlineattachnum,0,1)=="#")
                  {
                  // user erroneously added a # at start
                  $inlineattachnum = substr($inlineattachnum,1);
                  $inlineattachnum = strtolower(trim($inlineattachnum));
                  }
              }
          
          // reset inlined text we are going to compute
          $inlinedtext="";
    
          // blank incredments in sequence
          if (!isset($inlineattachnum) || $inlineattachnum=="")
              {
              // its just a keyword, assume attachment index increments
              $inlineattachnum=$lastinlineattachnum+1;
              $lastinlineattachnum=$inlineattachnum;
              }
    
    
          // adjust for 0 indexing
          if ($inlineattachnum > 0)
              --$inlineattachnum;
    
          // ok now find the text of the attachment being referred to
          if (isset($output['attachment'][$inlineattachnum]))
              $attachment = $output['attachment'][$inlineattachnum];
          else
              $attachment="";
    
          // ok got a reference to a valid existing attachment
          if ($attachment!="")
              {
                  // found a real attachment - now figure out how to include it
                if ($attachment['is_image'] && $tagkeyword!='attachurl' && $tagkeyword!='attachmini')
                    $inlinedtext = '[img]'.$attachment['href'].'[/img]';
                else if ($tagkeyword=='attachmini')
                    {
                    // attach as url - no other options - this works for images or any file type
                    // useful if you want to attach an image but still have it displayed as an image
                    // the mini means dont display details like size and download count.
                    $inlinedtext = '[url="'.$attachment['href'].'"]'.$attachment['name'].'[/url]';
                    }
                else
                    {
                    // attach as url - no other options - this works for images or any file type
                    // useful if you want to attach an image but still have it displayed as an image
                    $inlinedtext = '[url="'.$attachment['href'].'"]' . $attachment['name'] . '</a> ('. $attachment['size']. ($attachment['is_image'] ? '. ' . $attachment['real_width'] . 'x' . $attachment['real_height'] . ' - ' . $txt['attach_viewed'] : ' - ' . $txt['attach_downloaded']) . ' ' . $attachment['downloads'] . ' ' . $txt['attach_times'] . '.)'.'[/url]' ;
                    }
        
                // set flag saying we inlined it, so we dont add it at end
                $attachmentreferences[$inlineattachnum]=1;
            }
        else
            {
            // couldnt find attachment specified - so say so
            // they may have specified it wrong or they dont have permissions for attachments (unregged visitor)
            //$inlinedtext = 'tried to inline include (' . $tagkeyword . ') attachment #' . ($inlineattachnum + 1) . ' but it could not be found (or you don\'t have permission to view images).</br>';
            if (!empty($modSettings['attachmentEnable']) && allowedTo('view_attachments'))
                $inlinedtext = $txt['mod_aim_attachment_missing'];
            else
                $inlinedtext = $txt['mod_aim_forbiden_for_guest'];
            }
    
        // replace message body item with new text we just created
        $output['body']=substr_replace($output['body'],$inlinedtext,$startpos,$taglen+2);
    
        // advanced startsearchpos to avoid all posibility of recursive expansions on some bad code
        $startsearchpos = $startpos+strlen($inlinedtext);
        }
        //---------------------------------------------------------------------------
    }
    return $output;
}
// Load the installed packages.
function mobi_loadInstalledPackages()
{
    global $boarddir, $smcFunc;

    // First, check that the database is valid, installed.list is still king.
    $install_file = implode('', file($boarddir . '/Packages/installed.list'));
    if (trim($install_file) == '')
    {
        $smcFunc['db_query']('', '
            UPDATE {db_prefix}log_packages
            SET install_state = {int:not_installed}',
            array(
                'not_installed' => 0,
            )
        );

        // Don't have anything left, so send an empty array.
        return array();
    }

    // Load the packages from the database - note this is ordered by install time to ensure latest package uninstalled first.
    $request = $smcFunc['db_query']('', '
        SELECT id_install, package_id, filename, name, version
        FROM {db_prefix}log_packages
        WHERE install_state != {int:not_installed}
        ORDER BY time_installed DESC',
        array(
            'not_installed' => 0,
        )
    );
    $installed = array();
    $found = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        // Already found this? If so don't add it twice!
        if (in_array($row['package_id'], $found))
            continue;

        $found[] = $row['package_id'];

        $installed[] = array(
            'id' => $row['id_install'],
            'name' => $row['name'],
            'filename' => $row['filename'],
            'package_id' => $row['package_id'],
            'version' => $row['version'],
        );
    }
    $smcFunc['db_free_result']($request);

    return $installed;
}
function action_get_latest_topic()
{
    action_get_new_topic();
}

function action_get_new_topic()
{
    global $context, $settings, $scripturl, $db_prefix, $user_info, $topic_per_page, $start_num;
    global $modSettings, $smcFunc;

    $num_recent = $topic_per_page;
    $exclude_boards = null;
    $include_boards = null;

    if ($exclude_boards === null && !empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0)
        $exclude_boards = array($modSettings['recycle_board']);
    else
        $exclude_boards = empty($exclude_boards) ? array() : (is_array($exclude_boards) ? $exclude_boards : array($exclude_boards));

    // Only some boards?.
    if (is_array($include_boards) || (int) $include_boards === $include_boards)
    {
        $include_boards = is_array($include_boards) ? $include_boards : array($include_boards);
    }
    elseif ($include_boards != null)
    {
        $output_method = $include_boards;
        $include_boards = array();
    }

    $stable_icons = array('xx', 'thumbup', 'thumbdown', 'exclamation', 'question', 'lamp', 'smiley', 'angry', 'cheesy', 'grin', 'sad', 'wink', 'moved', 'recycled', 'wireless');
    $icon_sources = array();
    foreach ($stable_icons as $icon)
        $icon_sources[$icon] = 'images_url';

    // Find all the posts in distinct topics.  Newer ones will have higher IDs.
    $request = $smcFunc['db_query']('substring', '
        SELECT
            m.poster_time, SUBSTRING(m.body, 1, 384) AS body, m.smileys_enabled, m.icon, ms.subject, m.id_topic, m.id_member, m.id_msg, b.id_board, b.name AS board_name, t.num_replies, t.num_views,
            t.id_member_started, t.approved, t.is_sticky, locked, t.id_topic,
            IFNULL(mem.real_name, m.poster_name) AS poster_name, mem.avatar as avatar_last' . ($user_info['is_guest'] ? ', 1 AS is_read, 0 AS new_from' : ',
            IFNULL(lt.id_msg, IFNULL(lmr.id_msg, 0)) >= m.id_msg_modified AS is_read,
            IFNULL(lt.id_msg, IFNULL(lmr.id_msg, -1)) + 1 AS new_from,
            IFNULL(al.id_attach, 0) AS id_attach_last, al.filename as filename_last, al.attachment_type as attachment_type_last') . '
        FROM {db_prefix}topics AS t
            INNER JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_last_msg)
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)
            INNER JOIN {db_prefix}messages AS ms ON (ms.id_msg = t.id_first_msg)
            LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = m.id_member)' . (!$user_info['is_guest'] ? '
            LEFT JOIN {db_prefix}log_topics AS lt ON (lt.id_topic = t.id_topic AND lt.id_member = {int:current_member})
            LEFT JOIN {db_prefix}log_mark_read AS lmr ON (lmr.id_board = b.id_board AND lmr.id_member = {int:current_member})
            LEFT JOIN {db_prefix}attachments AS al ON (al.id_member = mem.id_member)' : '') . '
        WHERE t.id_last_msg >= {int:min_message_id}
            ' . (empty($exclude_boards) ? '' : '
            AND b.id_board NOT IN ({array_int:exclude_boards})') . '
            ' . (empty($include_boards) ? '' : '
            AND b.id_board IN ({array_int:include_boards})') . '
            AND {query_wanna_see_board}' . ($modSettings['postmod_active'] ? '
            AND t.approved = {int:is_approved}
            AND m.approved = {int:is_approved}' : '') . '
        ORDER BY t.id_last_msg DESC
        LIMIT {int:offset}, {int:items_per_page}',
        array(
            'current_member' => $user_info['id'],
            'include_boards' => empty($include_boards) ? '' : $include_boards,
            'exclude_boards' => empty($exclude_boards) ? '' : $exclude_boards,
            'min_message_id' => $modSettings['maxMsgID'] - 35 * min($num_recent, 5),
            'is_approved'    => 1,
            'offset'         => $start_num,
            'items_per_page' => $topic_per_page,
        )
    );

    $perms_action_array = array('mark_notify', 'remove_any', 'remove_own', 'lock_any', 'lock_own', 'make_sticky', 'move_any', 'move_own', 'modify_any', 'modify_own', 'approve_posts');
    $mobi_permission = array();
    $posts = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        $row['body'] = preg_replace('/\[quote.*?\].*\[\/quote\]/si', '', $row['body']);
        $row['body'] = preg_replace('/\[img.*?\].*?\[\/img\]/si', '###img###', $row['body']);
        $row['body'] = strip_tags(strtr(mobiquo_parse_bbc($row['body'], false, $row['id_msg']), array('<br />' => ' ')));
        $row['body'] = preg_replace('/###img###/si', '[img]', $row['body']);
        if ($smcFunc['strlen']($row['body']) > 128)
            $row['body'] = $smcFunc['substr']($row['body'], 0, 128) . '...';

        // Censor the subject.
        censorText($row['subject']);
        censorText($row['body']);

        if (empty($modSettings['messageIconChecks_disable']) && !isset($icon_sources[$row['icon']]))
            $icon_sources[$row['icon']] = file_exists($settings['theme_dir'] . '/images/post/' . $row['icon'] . '.gif') ? 'images_url' : 'default_images_url';

        // Check for notifications on this topic
        $req = $smcFunc['db_query']('', '
            SELECT sent, id_topic
            FROM {db_prefix}log_notify
            WHERE id_topic = {int:current_topic} AND id_member = {int:current_member}
            LIMIT 1',
            array(
                'current_member' => $user_info['id'],
                'current_topic' => $row['id_topic'],
            )
        );

        $started = $row['id_member_started'] == $user_info['id'];

        $fid = $row['id_board'];
        foreach ($perms_action_array as $perm)
            if (!isset($mobi_permission[$fid][$perm])) $mobi_permission[$fid][$perm] = allowedTo($perm, $fid);
        // Build the array.
        $posts[] = array(
            'board' => array(
                'id' => $row['id_board'],
                'name' => $row['board_name'],
                'href' => $scripturl . '?board=' . $row['id_board'] . '.0',
                'link' => '<a href="' . $scripturl . '?board=' . $row['id_board'] . '.0">' . $row['board_name'] . '</a>'
            ),
            'topic' => $row['id_topic'],
            'poster' => array(
                'id' => $row['id_member'],
                'name' => $row['poster_name'],
                'href' => empty($row['id_member']) ? '' : $scripturl . '?action=profile;u=' . $row['id_member'],
                'link' => empty($row['id_member']) ? $row['poster_name'] : '<a href="' . $scripturl . '?action=profile;u=' . $row['id_member'] . '">' . $row['poster_name'] . '</a>',
                'avatar' => $row['avatar_last'] == '' ? ($row['id_attach_last'] > 0 ? (empty($row['attachment_type_last']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach_last'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename_last']) : '') : (stristr($row['avatar_last'], 'http://') ? $row['avatar_last'] : $modSettings['avatar_url'] . '/' . $row['avatar_last']),
            ),
            'subject' => $row['subject'],
            'replies' => $row['num_replies'],
            'views' => $row['num_views'],
            'short_subject' => shorten_subject($row['subject'], 25),
            'preview' => $row['body'],
            'time' => timeformat($row['poster_time']),
            'timestamp' => forum_time(true, $row['poster_time']),
            'href' => $scripturl . '?topic=' . $row['id_topic'] . '.msg' . $row['id_msg'] . ';topicseen#new',
            'link' => '<a href="' . $scripturl . '?topic=' . $row['id_topic'] . '.msg' . $row['id_msg'] . '#new" rel="nofollow">' . $row['subject'] . '</a>',
            // Retained for compatibility - is technically incorrect!
            'new' => !empty($row['is_read']),
            'is_new' => empty($row['is_read']),
            'new_from' => $row['new_from'],
            'icon' => $settings[$icon_sources[$row['icon']]] . '/post/' . $row['icon'] . '.gif" align="middle" alt="' . $row['icon'],

            'can_lock' => $mobi_permission[$fid]['lock_any'] || ($started && $mobi_permission[$fid]['lock_own']),
            'can_sticky' => $mobi_permission[$fid]['make_sticky'] && !empty($modSettings['enableStickyTopics']),
            'can_move' => $mobi_permission[$fid]['move_any'] || ($started && $mobi_permission[$fid]['move_own']),
            'can_modify' => $mobi_permission[$fid]['modify_any'] || ($started && $mobi_permission[$fid]['modify_own']),
            'can_remove' => $mobi_permission[$fid]['remove_any'] || ($started && $mobi_permission[$fid]['remove_own']),
            'can_approve' => $mobi_permission[$fid]['approve_posts'],
            'can_mark_notify' => $mobi_permission[$fid]['mark_notify'] && !$user_info['is_guest'],

            'is_sticky' => !empty($modSettings['enableStickyTopics']) && !empty($row['is_sticky']),
            'is_locked' => !empty($row['locked']),
            'is_approved' => !empty($row['approved']),
            'is_marked_notify' => $smcFunc['db_num_rows']($req) ? true : false,
            //'new' => $topic['new_from'] <= $topic['id_msg_modified'],
        );
        $smcFunc['db_free_result']($req);
    }
    $smcFunc['db_free_result']($request);

    $context['posts'] = $posts;
}

function action_register()
{
    global $sourcedir, $context, $modSettings, $request_name, $maintenance, $mmessage, $tid_sign_in;

    checkSession();
    
    if(empty($_POST['password'])) get_error('password cannot be empty');
    if(!($maintenance == 0)) get_error('Forum is in maintenance model or Tapatalk is disabled by forum administrator.');
    
    if ($modSettings['registration_method'] == 0)
        $register_mode = 'nothing';
    else if ($modSettings['registration_method'] == 1)
        $register_mode = $_POST['emailActivate'] === false ? 'nothing' : 'activation';
    else
        $register_mode = 'approval';
    
    foreach ($_POST as $key => $value)
        if (!is_array($_POST[$key]))
            $_POST[$key] = htmltrim__recursive(str_replace(array("\n", "\r"), '', $_POST[$key]));
    
    $_POST['group'] = 0;
    if ($register_mode == 'nothing' && isset($modSettings['tp_iar_usergroup_assignment'])) {
        $_POST['group'] = $modSettings['tp_iar_usergroup_assignment'];
    }
    $regOptions = array(
        'interface' => $register_mode == 'approval' ? 'guest' : 'admin',
        'username' => $_POST['user'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'password_check' => $_POST['password'],
        'check_reserved_name' => true,
        'check_password_strength' => true,
        'check_email_ban' => false,
        'send_welcome_email' => isset($_POST['emailPassword']) || empty($_POST['password']),
        'require' => $register_mode,
        'memberGroup' => (int) $_POST['group'],
    );
    
    define('mobi_register',1);
    require_once($sourcedir . '/Subs-Members.php');
    $memberID = registerMember($regOptions);

    if (!empty($memberID))
    {
        $context['new_member'] = array(
            'id' => $memberID,
            'name' => $_POST['user'],
            'href' => $scripturl . '?action=profile;u=' . $memberID,
            'link' => '<a href="' . $scripturl . '?action=profile;u=' . $memberID . '">' . $_POST['user'] . '</a>',
        );
        $context['registration_done'] = sprintf($txt['admin_register_done'], $context['new_member']['link']);
    }
    if(!empty($memberID) && $tid_sign_in)
    {
        //update profile
        if(isset($_POST['tid_profile']) && !empty($_POST['tid_profile']) && is_array($_POST['tid_profile']))
        {
            $profile_vars = array(
                'avatar' => $_POST['tid_profile']['avatar_url'],
                //'birthdate' => $_POST['tid_profile']['birthday'],
                //'gender' => $_POST['tid_profile']['gender'] == 'male' ? 1 : 2,
                //'location' => $_POST['tid_profile']['location'],
                //'personal_text' => $_POST['tid_profile']['description'],
                //'signature' => $_POST['tid_profile']['signature'],
                //'website_url' => $_POST['tid_profile']['link'],
            );
            updateMemberData($memberID, $profile_vars);
        }

        //simulate login
        $request_name = 'login';
        $_REQUEST['action'] = $_GET['action'] = $_POST['action'] = 'login2';
        before_action_login();
        require_once('include/LogInOut.php');
        Login2();
    }
}

function action_get_subscribed_forum()
{
    global $context, $smcFunc, $scripturl, $user_info, $settings;

    $request = $smcFunc['db_query']('', '
        SELECT b.id_board, b.name, IFNULL(lb.id_msg, 0) AS board_read, b.id_msg_updated, b.redirect
        FROM {db_prefix}log_notify AS ln
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = ln.id_board)
            LEFT JOIN {db_prefix}log_boards AS lb ON (lb.id_board = b.id_board AND lb.id_member = {int:current_member})
        WHERE ln.id_member = {int:current_member}
            AND {query_see_board}
        ORDER BY b.board_order',
        array(
            'current_member' => $user_info['id'],
        )
    );
    $notification_boards = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        if ($row['board_read'] < $row['id_msg_updated'])
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'on.png';
        elseif ($row['redirect'])
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'redirect.png';
        else
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'off.png';

        $notification_boards[] = array(
            'id' => $row['id_board'],
            'name' => $row['name'],
            'logo' => $logo_url,
            'new' => $row['board_read'] < $row['id_msg_updated']
        );
    }
    $smcFunc['db_free_result']($request);

    $context['boards'] = $notification_boards;
}

function action_get_subscribed_topic()
{
    global $smcFunc, $scripturl, $user_info, $context, $modSettings, $start, $limit;

    // All the topics with notification on...
    $request = $smcFunc['db_query']('', '
        SELECT t.id_topic, b.id_board, b.name AS board_name
        FROM {db_prefix}log_notify AS ln
            INNER JOIN {db_prefix}topics AS t ON (t.id_topic = ln.id_topic' . ($modSettings['postmod_active'] ? ' AND t.approved = {int:is_approved}' : '') . ')
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board AND {query_see_board})
        WHERE ln.id_member = {int:current_member} AND ln.id_topic != 0
        ORDER BY t.id_last_msg DESC
        LIMIT {int:offset}, {int:items_per_page}',
        array(
            'current_member' => $user_info['id'],
            'is_approved' => 1,
            'offset' => $start,
            'items_per_page' => $limit,
        )
    );

    $notification_topics = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        $notification_topics[] = $row;
    }
    $smcFunc['db_free_result']($request);

    $context['topics'] = $notification_topics;

    $request = $smcFunc['db_query']('', '
        SELECT COUNT(*)
        FROM {db_prefix}log_notify AS ln' . (!$modSettings['postmod_active'] && $user_info['query_see_board'] === '1=1' ? '' : '
            INNER JOIN {db_prefix}topics AS t ON (t.id_topic = ln.id_topic)') . ($user_info['query_see_board'] === '1=1' ? '' : '
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)') . '
        WHERE ln.id_member = {int:selected_member}
            AND ln.id_topic != 0 ' . ($user_info['query_see_board'] === '1=1' ? '' : '
            AND {query_see_board}') . ($modSettings['postmod_active'] ? '
            AND t.approved = {int:is_approved}' : ''),
        array(
            'selected_member' => $user_info['id'],
            'is_approved' => 1,
        )
    );
    list ($totalNotifications) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    $context['topic_num'] = $totalNotifications;
}
function action_update_push_status() {}

function action_get_alert() {}

function action_get_participated_topic()
{
    global $smcFunc, $scripturl, $user_info, $context, $modSettings, $topic_per_page, $start_num, $search_user, $user_id;

    $searchz_user_id = $user_info['id'];

    if ($search_user)
    {
        $search_user = $smcFunc['htmlspecialchars']($search_user);
        $memberResult = loadMemberData($search_user, true, 'profile');
        if (!is_array($memberResult))
            fatal_lang_error('not_a_user', false);

        list ($searchz_user_id) = $memberResult;
    }

    if ($user_id)
        $searchz_user_id = $user_id;
    // All the topics with notification on...
    $request = $smcFunc['db_query']('', '
        SELECT m.id_topic, MAX(m.id_msg) as id_msg, b.id_board, b.name AS board_name
        FROM {db_prefix}messages AS m
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = m.id_board AND {query_see_board})
        WHERE m.id_member = {int:current_member}
        GROUP BY m.id_topic
        ORDER BY id_msg DESC
        LIMIT {int:offset}, {int:items_per_page}',
        array(
            'current_member' => $searchz_user_id,
            'offset' => $start_num,
            'items_per_page' => $topic_per_page,
        )
    );

    $participated_topics = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        $participated_topics[] = $row;
    }
    $smcFunc['db_free_result']($request);

    $context['topics'] = $participated_topics;

    $request = $smcFunc['db_query']('', '
        SELECT COUNT(DISTINCT m.id_topic)
        FROM {db_prefix}messages AS m
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = m.id_board AND {query_see_board})
        WHERE m.id_member = {int:current_member}',
        array(
            'current_member' => $searchz_user_id,
        )
    );

    list ($totalParticipated) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    $context['topic_num'] = $totalParticipated;
}

function set_topic_and_board_by_message()
{
    global $smcFunc;

    $id_msg = isset($_GET['msg']) && $_GET['msg'] ? $_GET['msg'] : (isset($_GET['quote']) ? $_GET['quote'] : '');

    if(empty($id_msg)) return;
    $id_msg = explode('-', $id_msg);
    $id_msg = $id_msg[0];
    $request = $smcFunc['db_query']('', '
        SELECT id_topic, id_board
        FROM {db_prefix}messages
        WHERE id_msg = {int:message_id}',
        array(
            'message_id' => $id_msg,
        )
    );

    list ($topic_id, $board_id) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    if (empty($topic_id)) fatal_lang_error('topic_gone', false);

    $GLOBALS['topic'] = $topic_id;
    $GLOBALS['board'] = $board_id;
}

function action_mark_pm_read()
{
    require_once('include/PersonalMessage.php');
    
    is_not_guest();
    isAllowedTo('pm_read');
    loadLanguage('PersonalMessage');
    
     markMessages($_POST['id_pm']);
}

function action_mark_pm_unread()
{
    global $context, $smcFunc, $user_info, $mark_result;

    $mark_result =  1;
}

function action_get_inbox_stat()
{
    global $context, $smcFunc, $modSettings, $user_info, $pm_last_checked_time, $subscribed_topic_last_checked_time;

    // get unread pm number since last check time
    if ($pm_last_checked_time)
    {
        $result = $smcFunc['db_query']('', '
            SELECT COUNT(*) AS num
            FROM {db_prefix}pm_recipients pr
                INNER JOIN {db_prefix}personal_messages AS pm ON (pr.id_pm = pm.id_pm)
            WHERE pr.id_member = {int:id_member}
                AND NOT (pr.is_read & 1 >= 1)
                AND pr.deleted = {int:is_not_deleted}
                AND pm.msgtime > {int:pm_last_checked_time}
            GROUP BY labels',
            array(
                'id_member' => $user_info['id'],
                'is_not_deleted' => 0,
                'pm_last_checked_time' => $pm_last_checked_time,
            )
        );

        list ($inbox_unread_count) = $smcFunc['db_fetch_row']($result);
        $context['inbox_unread_count'] = $inbox_unread_count;
    }
    else
    {
        $context['inbox_unread_count'] = $user_info['unread_messages'];
    }

    // get unread subscribed topic number since last check time
    $request = $smcFunc['db_query']('', '
        SELECT ln.id_topic, IFNULL(lt.id_msg, IFNULL(lmr.id_msg, -1)) + 1 AS new_from, m.id_msg_modified
        FROM {db_prefix}log_notify AS ln
            INNER JOIN {db_prefix}topics AS t ON (t.id_topic = ln.id_topic)
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)
            LEFT JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_last_msg)
            LEFT JOIN {db_prefix}log_topics AS lt ON (lt.id_topic = t.id_topic AND lt.id_member = {int:current_member})
            LEFT JOIN {db_prefix}log_mark_read AS lmr ON (lmr.id_board = t.id_board AND lmr.id_member = {int:current_member})
        WHERE ln.id_member = {int:current_member}
            AND ln.id_topic != 0
            AND m.poster_time > {int:last_active_time}' . ($modSettings['postmod_active'] ? '
            AND t.approved = 1' : ''),
        array(
            'current_member'   => $user_info['id'],
            'last_active_time'  => $subscribed_topic_last_checked_time,
        )
    );

    $totalUnreadNotifications = 0;
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        if ($row['id_msg_modified'] > $row['new_from'] || $row['id_msg_modified'] == $row['new_from']) $totalUnreadNotifications++;
    }

    $context['totalUnreadNotifications'] = $totalUnreadNotifications;
    $smcFunc['db_free_result']($request);
}

function action_get_box_info()
{
    global $txt, $context, $user_info, $smcFunc;

    // No guests!
    is_not_guest();

    // You're not supposed to be here at all, if you can't even read PMs.
    isAllowedTo('pm_read');

    loadLanguage('PersonalMessage');

    // Load up the members maximum message capacity.
    if ($user_info['is_admin'])
        $context['message_limit'] = 360;
    elseif (($context['message_limit'] = cache_get_data('msgLimit:' . $user_info['id'], 360)) === null)
    {
        // !!! Why do we do this?  It seems like if they have any limit we should use it.
        $request = $smcFunc['db_query']('', '
            SELECT MAX(max_messages) AS top_limit, MIN(max_messages) AS bottom_limit
            FROM {db_prefix}membergroups
            WHERE id_group IN ({array_int:users_groups})',
            array(
                'users_groups' => $user_info['groups'],
            )
        );
        list ($maxMessage, $minMessage) = $smcFunc['db_fetch_row']($request);
        $smcFunc['db_free_result']($request);

        $context['message_limit'] = $minMessage == 0 ? 360 : $maxMessage;

        // Save us doing it again!
        cache_put_data('msgLimit:' . $user_info['id'], $context['message_limit'], 360);
    }

    $context['message_remain'] = $context['message_limit'] - $user_info['messages'];

    $request = $smcFunc['db_query']('', '
        SELECT COUNT(*)
        FROM {db_prefix}personal_messages AS pm
        WHERE pm.id_member_from = {int:current_member}
            AND pm.deleted_by_sender = {int:not_deleted}',
        array(
            'current_member' => $user_info['id'],
            'not_deleted' => 0,
        )
    );

    list ($sent_messages) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);


    $request = $smcFunc['db_query']('', '
        SELECT COUNT(*)
        FROM {db_prefix}pm_recipients AS pmr
        WHERE pmr.id_member = {int:current_member}
            AND pmr.deleted = {int:not_deleted}',
        array(
            'current_member' => $user_info['id'],
            'not_deleted' => 0,
        )
    );

    list ($inbox_messages) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    $context['boxes']['inbox'] = array(
        'id' => 'inbox',
        'name' => $txt['inbox'],
        'msg_count' => $inbox_messages,
        'unread_count' => $user_info['unread_messages'],
        'box_type' => 'INBOX',
    );

    if (allowedTo('pm_send')) {
        $context['boxes']['sent'] = array(
            'id' => 'sent',
            'name' => $txt['sent_items'],
            'msg_count' => $sent_messages,
            'unread_count' => 0,
            'box_type' => 'SENT',
        );
    }
}


function action_m_rename_topic()
{
    global $smcFunc, $context, $user_info, $topic, $modSettings, $txt;

    if (empty($topic))
        fatal_lang_error('no_access', false);
    
    $_POST['custom_subject'] = mobiquo_encode($_POST['custom_subject']);
    $request = $smcFunc['db_query']('', '
        SELECT id_member_started, id_first_msg, approved
        FROM {db_prefix}topics
        WHERE id_topic = {int:current_topic}
        LIMIT 1',
        array(
            'current_topic' => $topic,
        )
    );
    list ($id_member_started, $id_first_msg, $context['is_approved']) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    // Can they see it?
    if (!$context['is_approved'])
        isAllowedTo('approve_posts');

    // Can they move topics on this board?
    if (!allowedTo('move_any'))
    {
        if ($id_member_started == $user_info['id'])
        {
            isAllowedTo('move_own');
            $boards = array_merge(boardsAllowedTo('move_own'), boardsAllowedTo('move_any'));
        }
        else
            isAllowedTo('move_any');
    }
    else
        $boards = boardsAllowedTo('move_any');

    // If this topic isn't approved don't let them move it if they can't approve it!
    if ($modSettings['postmod_active'] && !$context['is_approved'] && !allowedTo('approve_posts'))
    {
        // Only allow them to move it to other boards they can't approve it in.
        $can_approve = boardsAllowedTo('approve_posts');
        $boards = array_intersect($boards, $can_approve);
    }

    checkSession();

    if (isset($_POST['custom_subject']) && $_POST['custom_subject'] != '')
    {
        $_POST['custom_subject'] = strtr($smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['custom_subject'])), array("\r" => '', "\n" => '', "\t" => ''));
        // Keep checking the length.
        if ($smcFunc['strlen']($_POST['custom_subject']) > 100)
            $_POST['custom_subject'] = $smcFunc['substr']($_POST['custom_subject'], 0, 100);

        // If it's still valid move onwards and upwards.
        if ($_POST['custom_subject'] != '')
        {
            if (isset($_POST['enforce_subject']))
            {
                // Get a response prefix, but in the forum's default language.
                if (!isset($context['response_prefix']) && !($context['response_prefix'] = cache_get_data('response_prefix')))
                {
                    if ($language === $user_info['language'])
                        $context['response_prefix'] = $txt['response_prefix'];
                    else
                    {
                        loadLanguage('index', $language, false);
                        $context['response_prefix'] = $txt['response_prefix'];
                        loadLanguage('index');
                    }
                    cache_put_data('response_prefix', $context['response_prefix'], 600);
                }

                $smcFunc['db_query']('', '
                    UPDATE {db_prefix}messages
                    SET subject = {string:subject}
                    WHERE id_topic = {int:current_topic}',
                    array(
                        'current_topic' => $topic,
                        'subject' => $context['response_prefix'] . $_POST['custom_subject'],
                    )
                );
            }

            $smcFunc['db_query']('', '
                UPDATE {db_prefix}messages
                SET subject = {string:custom_subject}
                WHERE id_msg = {int:id_first_msg}',
                array(
                    'id_first_msg' => $id_first_msg,
                    'custom_subject' => $_POST['custom_subject'],
                )
            );

            // Fix the subject cache.
            updateStats('subject', $topic, $_POST['custom_subject']);
            return;
        }
    }

    get_error($txt['error_no_subject']);
}


function after_action_get_box()
{
    global $txt, $context, $user_info, $smcFunc, $box_id;

    // Figure out how many messages there are.
    if ($box_id == 'sent')
    {
        $request = $smcFunc['db_query']('', '
            SELECT COUNT(*)
            FROM {db_prefix}personal_messages AS pm
            WHERE pm.id_member_from = {int:current_member}
                AND pm.deleted_by_sender = {int:not_deleted}',
            array(
                'current_member' => $user_info['id'],
                'not_deleted' => 0,
            )
        );
        list ($send_messages) = $smcFunc['db_fetch_row']($request);
        $smcFunc['db_free_result']($request);

        $context['messages_count'] = $send_messages;
    } else {
        $context['messages_count'] = $user_info['messages'];
    }

    $unread_messages = 0;
    $context['messages'] = array();
    while ($message = get_pm_list('subject'))
    {
        $context['messages'][] = $message;
        if($message['is_unread']) $unread_messages++;
    }
    $context['unread_messages'] = $unread_messages;
}

// Get a personal message for the theme.  (used to save memory.)
function get_pm_list($type = 'subject', $reset = false)
{
    global $txt, $user_profile, $scripturl, $modSettings, $context, $messages_request, $memberContext, $recipients, $smcFunc;
    global $user_info, $subjects_request;

    // Count the current message number....
    static $counter = null;
    if ($counter === null || $reset)
        $counter = $context['start'];

    static $temp_pm_selected = null;
    if ($temp_pm_selected === null)
    {
        $temp_pm_selected = isset($_SESSION['pm_selected']) ? $_SESSION['pm_selected'] : array();
        $_SESSION['pm_selected'] = array();
    }

    // Bail if it's false, ie. no messages.
    if ($messages_request == false)
        return false;

    // Reset the data?
    if ($reset == true)
        return @$smcFunc['db_data_seek']($messages_request, 0);

    // Get the next one... bail if anything goes wrong.
    $message = $smcFunc['db_fetch_assoc']($messages_request);
    if (!$message)
    {
        if ($type != 'subject')
            $smcFunc['db_free_result']($messages_request);

        return false;
    }

    // Use '(no subject)' if none was specified.
    $message['subject'] = $message['subject'] == '' ? $txt['no_subject'] : $message['subject'];

    // add for tapatalk
    if ($context['folder'] == 'sent') {
        $id_member = preg_replace('/^.*?u=(\d+).*?$/s', '$1', $recipients[$message['id_pm']]['to'][0]);
        if (!isset($user_profile[$id_member]))
            loadMemberData($id_member);
    } else
        $id_member = $message['id_member_from'];


    // Load the message's information - if it's not there, load the guest information.
    if (!loadMemberContext($id_member, true))
    {
        $memberContext[$id_member]['name'] = $message['from_name'];
        $memberContext[$id_member]['id'] = 0;
        // Sometimes the forum sends messages itself (Warnings are an example) - in this case don't label it from a guest.
        $memberContext[$id_member]['group'] = $message['from_name'] == $context['forum_name'] ? '' : $txt['guest_title'];
        $memberContext[$id_member]['link'] = $message['from_name'];
        $memberContext[$id_member]['email'] = '';
        $memberContext[$id_member]['show_email'] = showEmailAddress(true, 0);
        $memberContext[$id_member]['is_guest'] = true;
    }
    else
    {
        $memberContext[$id_member]['can_view_profile'] = allowedTo('profile_view_any') || ($id_member == $user_info['id'] && allowedTo('profile_view_own'));
        $memberContext[$id_member]['can_see_warning'] = !isset($context['disabled_fields']['warning_status']) && $memberContext[$id_member]['warning_status'] && (($context['user']['can_mod'] || !empty($modSettings['warning_show'])) || ($memberContext[$id_member]['id'] == $context['user']['id'] && !empty($modSettings['warning_show']) && $modSettings['warning_show'] == 1));
    }

    // Censor all the important text...
    censorText($message['body']);
    censorText($message['subject']);

    // Run UBBC interpreter on the message.
    $message['body'] = mobiquo_parse_bbc($message['body'], false, 'pm' . $message['id_pm']);

    // Send the array.
    $output = array(
        'alternate' => $counter % 2,
        'id' => $message['id_pm'],
        'member' => &$memberContext[$id_member],
        'subject' => $message['subject'],
        'time' => timeformat($message['msgtime']),
        'timestamp' => forum_time(true, $message['msgtime']),
        'counter' => $counter,
        'body' => $message['body'],
        'recipients' => &$recipients[$message['id_pm']],
        'number_recipients' => count($recipients[$message['id_pm']]['to']),
        'labels' => &$context['message_labels'][$message['id_pm']],
        'fully_labeled' => count($context['message_labels'][$message['id_pm']]) == count($context['labels']),
        'is_replied_to' => &$context['message_replied'][$message['id_pm']],
        'is_unread' => &$context['message_unread'][$message['id_pm']],
        'is_selected' => !empty($temp_pm_selected) && in_array($message['id_pm'], $temp_pm_selected),
        'msg_from' => $context['folder'] == 'sent' ? $context['user']['name'] : $memberContext[$id_member]['name'],
        'msg_from_id' => $id_member,
    );

    $counter++;

    return $output;
}

function action_get_participated_forum()
{
    global $smcFunc, $user_info, $context, $settings;

    $searchz_user_id = $user_info['id'];

    // All the topics with notification on...
    $request = $smcFunc['db_query']('', '
        SELECT DISTINCT(b.id_board), b.name, IFNULL(lb.id_msg, 0) AS board_read, b.id_msg_updated
        FROM {db_prefix}messages AS m
            INNER JOIN {db_prefix}boards AS b ON (b.id_board = m.id_board AND {query_see_board})
            LEFT JOIN {db_prefix}log_boards AS lb ON (lb.id_board = b.id_board AND lb.id_member = {int:current_member})
        WHERE m.id_member = {int:current_member}
        ORDER BY b.id_board',
        array(
            'current_member' => $searchz_user_id,
        )
    );

    $participated_boards = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        if ($row['board_read'] < $row['id_msg_updated'])
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'on.png';
        else
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'off.png';

        $participated_boards[] = array(
            'id' => $row['id_board'],
            'name' => $row['name'],
            'logo' => $logo_url,
            'new' => $row['board_read'] < $row['id_msg_updated']
        );
    }
    $smcFunc['db_free_result']($request);

    $context['boards'] = $participated_boards;
}

function action_get_forum_status()
{
    global $smcFunc, $user_info, $context, $settings;

    $searchz_user_id = $user_info['id'];

    // All the topics with notification on...
    $request = $smcFunc['db_query']('', '
        SELECT b.id_board, b.name, IFNULL(lb.id_msg, 0) AS board_read, b.id_msg_updated
        FROM {db_prefix}boards AS b
            LEFT JOIN {db_prefix}log_boards AS lb ON (lb.id_board = b.id_board AND lb.id_member = {int:current_member})
        WHERE b.id_board IN ({array_int:forum_ids}) AND {query_see_board}
        ORDER BY b.id_board',
        array(
            'current_member' => $searchz_user_id,
            'forum_ids'      => $_GET['forum_ids'],
        )
    );

    $boards = array();
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        if ($row['board_read'] < $row['id_msg_updated'])
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'on.png';
        else
            $logo_url = $settings['images_url'].'/'.$context['theme_variant_url'].'off.png';

        $boards[] = array(
            'id' => $row['id_board'],
            'name' => $row['name'],
            'logo' => $logo_url,
            'new' => $row['board_read'] < $row['id_msg_updated']
        );
    }
    $smcFunc['db_free_result']($request);

    $context['boards'] = $boards;
}

// Loads a single PM
function action_get_message()
{
    global $context, $smcFunc, $modSettings, $scripturl, $sourcedir, $user_info, $msg_id, $box_id, $user_profile, $memberContext;

    require_once('include/PersonalMessage.php');

    // No guests!
    is_not_guest();

    // You're not supposed to be here at all, if you can't even read PMs.
    isAllowedTo('pm_read');

    loadLanguage('PersonalMessage');

    $request = $smcFunc['db_query']('', '
        SELECT pm.id_member_from, pm.msgtime, pm.subject, pm.body, m.member_name, m.real_name
        FROM {db_prefix}personal_messages AS pm
            LEFT JOIN {db_prefix}members AS m ON (pm.id_member_from = m.id_member)
        WHERE pm.id_pm = {int:id_message} ' . ($box_id == 'sent' ? 'AND pm.id_member_from = {int:current_member} AND pm.deleted_by_sender = 0' : ''),
        array(
            'id_message' => $msg_id,
            'current_member' => $user_info['id'],
        )
    );
    $pm = $smcFunc['db_fetch_assoc']($request);
    $smcFunc['db_free_result']($request);

    if (empty($pm))
        fatal_lang_error('no_access', false);

    censorText($pm['subject']);
    censorText($pm['body']);

    $context['pm'] = array(
        'id_member' => $pm['id_member_from'],
        'username' => $pm['member_name'],
        'name' => $pm['real_name'],
        'time' => timeformat($pm['msgtime']),
        'timestamp' => $pm['msgtime'],
        'subject' => $pm['subject'],
        'body' => mobiquo_parse_bbc($pm['body'], false, 'pm' . $msg_id),
        'recipients' => array(),
    );

    $request = $smcFunc['db_query']('', '
        SELECT pmr.id_member, m.member_name, m.real_name
        FROM {db_prefix}pm_recipients AS pmr
            LEFT JOIN {db_prefix}members AS m ON (pmr.id_member = m.id_member)
        WHERE pmr.id_pm = {int:id_message} ' . ($box_id == 'inbox' ? 'AND ((pmr.id_member = {int:current_member} AND pmr.deleted = 0) OR (pmr.id_member != {int:current_member} AND pmr.bcc = 0))' : ''),
        array(
            'id_message' => $msg_id,
            'current_member' => $user_info['id'],
        )
    );

    $no_member = true;
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        $context['pm']['recipients'][] = new xmlrpcval(array(
            'user_id'  => new xmlrpcval(basic_clean($row['id_member'])),
            'username' => new xmlrpcval(basic_clean($row['real_name']), 'base64'),
        ), 'struct');

        if ($no_member)
        {
            $display_member_id = ($box_id == 'inbox' ? $pm['id_member_from'] : $row['id_member']);
            $no_member = false;
        }
    }
    $smcFunc['db_free_result']($request);

    loadMemberData($display_member_id);
    loadMemberContext($display_member_id);
    $context['pm']['member'] = $memberContext[$display_member_id];

    if ($no_avatar)
        fatal_lang_error('no_access', false);

    // Mark this as read, if it is not already
    markMessages(array($msg_id));
}

function action_attach_image()
{
    global $image, $modSettings, $sourcedir, $context, $user_info;

    require_once('include/Subs-Post.php');

    if (isset($_FILES['attachment']['name']))
    {
        // Verify they can post them!
        if (!$modSettings['postmod_active'] || !allowedTo('post_unapproved_attachments'))
            isAllowedTo('post_attachment');

        // Make sure we're uploading to the right place.
        if (!empty($modSettings['currentAttachmentUploadDir']))
        {
            if (!is_array($modSettings['attachmentUploadDir']))
                $modSettings['attachmentUploadDir'] = unserialize($modSettings['attachmentUploadDir']);

            // The current directory, of course!
            $current_attach_dir = $modSettings['attachmentUploadDir'][$modSettings['currentAttachmentUploadDir']];
        }
        else
            $current_attach_dir = $modSettings['attachmentUploadDir'];

        // prepare for attach image
        $tmp_name = 'post_tmp_' . $user_info['id'] . '_' . rand(1, 1000);
        $destination = $current_attach_dir . '/' . $tmp_name;
        $fp = fopen($destination, 'w');
        $size = @filesize($destination);
        fwrite($fp, $image);
        fclose($fp);

        $_FILES['attachment']['tmp_name'][] = $tmp_name;
        $_FILES['attachment']['size'][] = $size ? $size : strlen($image);

        $quantity = 0;
        $total_size = 0;

        if (!isset($_FILES['attachment']['name']))
            $_FILES['attachment']['tmp_name'] = array();

        $attachIDs = array();
        foreach ($_FILES['attachment']['tmp_name'] as $n => $dummy)
        {
            if ($_FILES['attachment']['name'][$n] == '')
                continue;

            // Have we reached the maximum number of files we are allowed?
            $quantity++;
            if (!empty($modSettings['attachmentNumPerPostLimit']) && $quantity > $modSettings['attachmentNumPerPostLimit'])
            {
                checkSubmitOnce('free');
                fatal_lang_error('attachments_limit_per_post', false, array($modSettings['attachmentNumPerPostLimit']));
            }

            // Check the total upload size for this post...
            $total_size += $_FILES['attachment']['size'][$n];
            if (!empty($modSettings['attachmentPostLimit']) && $total_size > $modSettings['attachmentPostLimit'] * 1024)
            {
                checkSubmitOnce('free');
                fatal_lang_error('file_too_big', false, array($modSettings['attachmentPostLimit']));
            }

            $attachmentOptions = array(
                'post' => 0,
                'poster' => $user_info['id'],
                'name' => $_FILES['attachment']['name'][$n],
                'tmp_name' => $_FILES['attachment']['tmp_name'][$n],
                'size' => $_FILES['attachment']['size'][$n],
                'approved' => !$modSettings['postmod_active'] || allowedTo('post_attachment'),
            );

            if (createAttachment($attachmentOptions))
            {
                $attachIDs[] = $attachmentOptions['id'];
                if (!empty($attachmentOptions['thumb']))
                    $attachIDs[] = $attachmentOptions['thumb'];
            }
            else
            {
                if (in_array('could_not_upload', $attachmentOptions['errors']))
                {
                    checkSubmitOnce('free');
                    fatal_lang_error('attach_timeout', 'critical');
                }
                if (in_array('too_large', $attachmentOptions['errors']))
                {
                    checkSubmitOnce('free');
                    fatal_lang_error('file_too_big', false, array($modSettings['attachmentSizeLimit']));
                }
                if (in_array('bad_extension', $attachmentOptions['errors']))
                {
                    checkSubmitOnce('free');
                    fatal_error($attachmentOptions['name'] . ".\n" . $txt['cant_upload_type'] . ' ' . $modSettings['attachmentExtensions'] . '.', false);
                }
                if (in_array('directory_full', $attachmentOptions['errors']))
                {
                    checkSubmitOnce('free');
                    fatal_lang_error('ran_out_of_space', 'critical');
                }
                if (in_array('bad_filename', $attachmentOptions['errors']))
                {
                    checkSubmitOnce('free');
                    fatal_error(basename($attachmentOptions['name']) . ".\n" . $txt['restricted_filename'] . '.', 'critical');
                }
                if (in_array('taken_filename', $attachmentOptions['errors']))
                {
                    checkSubmitOnce('free');
                    fatal_lang_error('filename_exists');
                }
            }
        }
        $context['attachids'] = $attachIDs;
    }
}

function before_action_create_message()
{
    global $txt, $smcFunc;

    if(empty($_POST['subject'])) get_error('Subject cannot be empty!'); 
    if(empty($_POST['message'])) get_error('Message content cannot be empty!'); 

    // Figure out how many messages there are.
    foreach ($_POST['recipient_to'] as $index => $name)
    {
        $request = $smcFunc['db_query']('', '
            SELECT id_member
            FROM {db_prefix}members
            WHERE member_name = {string:current_member} or
                  real_name = {string:current_member}',
            array(
                'current_member' => $smcFunc['htmlspecialchars']($name),
            )
        );
        list ($id_member) = $smcFunc['db_fetch_row']($request);
        $smcFunc['db_free_result']($request);

        if ($id_member)
            $_POST['recipient_to'][$index] = $id_member;
        else
            fatal_lang_error('error_bad_to');
    }
}

function before_action_register()
{
    global $modSettings, $params_num, $sourcedir;
    
    exttMbqMakeFlags();
    
    // emailActivate is ture means can not auto active
    $_POST['emailActivate'] = true;
    
    if($params_num == 5)
    {
        if (!ExttMbqBase::$otherParameters['exttMbqSsoRegister']) {
            fatal_lang_error('registration_disabled', false);
        }
        
        $email_response = getEmailFromScription($_POST['token'], $_POST['code'], $modSettings['tp_push_key']);
        if(empty($email_response))
            fatal_error('Sorry, this community has not yet full configured to work with Tapatalk, this feature has been disabled.');
        
        if( (!isset($_POST['email']) || empty($_POST['email'])) && (!isset($email_response['email']) || empty($email_response['email'])))
            fatal_error('Tapatalk ID session expired, please re-login Tapatalk ID and try again, if the problem persist please contact us.');
        
        $_POST['emailActivate'] = $email_response['result'] && isset($email_response['email']) && !empty($email_response['email']) && ($email_response['email'] == $_POST['email']) ? false : true;
    } else {
        if (!ExttMbqBase::$otherParameters['exttMbqNativeRegister']) {
            fatal_lang_error('registration_disabled', false);
        }
        require_once($sourcedir . '/Subs-Tapatalk.php');
        $tp_iar_spam_prevention = isset($modSettings['tp_iar_spam_prevention']) ? $modSettings['tp_iar_spam_prevention'] : 1;
        if ($tp_iar_spam_prevention == 1 || $tp_iar_spam_prevention == 3) {
            if (exttmbq_is_spam($_POST['email'], exttMbqGetIP())) {
                fatal_error('Sorry, can not register new user with spam info.');
            }
        }
    }
}

function before_action_sign_in()
{
    global $modSettings, $request_name, $tid_sign_in;
    
    exttMbqMakeFlags();
    
    $_REQUEST['username'] = $_GET['username'] = $_POST['username'] = mobiquo_encode($_POST['username']);
    
    if(!isset($modSettings['tp_push_key']) || empty($modSettings['tp_push_key']))
        $modSettings['tp_push_key'] = '';
    
    $_POST['emailActivate'] = true;
    $email_response = getEmailFromScription($_POST['token'], $_POST['code'], $modSettings['tp_push_key']);

    if(empty($email_response))
        get_error('Failed to connect to tapatalk server, please try again later.');
    if( (!isset($_POST['email']) || empty($_POST['email'])) && (!isset($email_response['email']) || empty($email_response['email'])))
        get_error('You need to input an email or re-login tapatalk id to use default email of tapatalk id.');

    $response_verified = $email_response['result'] && isset($email_response['email']) && !empty($email_response['email']);
    if(!$response_verified)
        return get_error(isset($email_response['result_text'])? $email_response['result_text'] : 'Tapatalk ID session expired, please re-login Tapatalk ID and try again, if the problem persist please tell us.');

    $_POST['tid_profile'] = isset($email_response['profile']) && !empty($email_response['profile']) ? $email_response['profile'] : '';

    if(!empty($_POST['email']))
    {
        if($email_response['email'] == $_POST['email'])
        {
            $user = get_user_by_name_or_email($_POST['email'] , true);
            if(isset($user['id_member']) && !empty($user['id_member']))
            {
                //prepare login parameter
                $_REQUEST['action'] = $_GET['action'] = $_POST['action'] = 'login2';
                $_REQUEST['user'] = $_GET['user'] = $_POST['user'] = $user['member_name'];
                $_REQUEST['passwrd'] = $_GET['passwrd'] = $_POST['passwrd'] = $_POST['password'];
                $_REQUEST['cookielength'] = $_GET['cookielength'] = $_POST['cookielength'] = -1;
                $request_name = 'login';
                $tid_sign_in = true;
                before_action_login();
            }
            else
            {
                if(!empty($_POST['username']))
                {
                    $user2 = get_user_by_name_or_email($_POST['username']);
                    if(isset($user2['id_member']) && !empty($user2['id_member'])) return error_status(1);

                    //prepare reg parameter
                    $_REQUEST['action'] = $_GET['action'] = $_POST['action'] = '';
                    $_REQUEST['passwrd'] = $_GET['passwrd'] = $_POST['passwrd'] = $_POST['password'];
                    $_REQUEST['user'] = $_GET['user'] = $_POST['user'] = $_POST['username'];
                    $_REQUEST['cookielength'] = $_GET['cookielength'] = $_POST['cookielength'] = -1;
                    $_POST['emailActivate'] = false;
                    $_REQUEST['user'] = $_GET['user'] = $_POST['user'] = $_POST['username'];
                    $request_name = 'register';
                    $tid_sign_in = true;
                    if (!ExttMbqBase::$otherParameters['exttMbqSsoSignin']) {
                        fatal_lang_error('registration_disabled', false);
                    }
                }
                else
                {
                    return error_status(2);
                }
            }
        }
        else
        {
            return error_status(3);
        }
    }
    else if(!empty($_POST['username']))
    {
        $user = get_user_by_name_or_email($_POST['username']);

        if(isset($user['id_member']) && !empty($user['id_member']) && $user['email_address'] == $email_response['email'])
        {
            //prepare login parameter
            $_REQUEST['action'] = $_GET['action'] = $_POST['action'] = 'login2';
            $_REQUEST['user'] = $_GET['user'] = $_POST['user'] = $_POST['username'];
            $_REQUEST['passwrd'] = $_GET['passwrd'] = $_POST['passwrd'] = $_POST['password'];
            $_REQUEST['cookielength'] = $_GET['cookielength'] = $_POST['cookielength'] = -1;
            $request_name = 'login';
            $tid_sign_in = true;
            before_action_login();
        }
        else
        {
            return error_status(3);
        }
    }
    else
    {
        $user = get_user_by_name_or_email($email_response['email'], true);
        if(isset($user['id_member']) && !empty($user['id_member']))
        {
            //prepare login parameter
            $_REQUEST['action'] = $_GET['action'] = $_POST['action'] = 'login2';
            $_REQUEST['user'] = $_GET['user'] = $_POST['user'] = $user['member_name'];
            $_REQUEST['passwrd'] = $_GET['passwrd'] = $_POST['passwrd'] = $_POST['password'];
            $_REQUEST['cookielength'] = $_GET['cookielength'] = $_POST['cookielength'] = -1;
            $request_name = 'login';
            $tid_sign_in = true;
            before_action_login();
        }
        else
        {
            return error_status(2);
        }
    }
}

function action_sign_in()
{
}

function before_action_reply_topic()
{
    check_topic_notify();
}

function before_action_reply_post()
{
    global $smcFunc, $topic, $board, $context, $language, $txt, $user_info;

    if(empty($_POST['message']))
        fatal_lang_error('error_no_message');

    $request = $smcFunc['db_query']('', '
        SELECT t.locked, t.is_sticky, t.id_poll, t.approved, t.id_first_msg, t.id_last_msg, t.id_member_started, t.id_board, m.subject
        FROM {db_prefix}topics AS t
            INNER JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_first_msg)
        WHERE t.id_topic = {int:current_topic}
        LIMIT 1',
        array(
            'current_topic' => $topic,
        )
    );
    $topic_info = $smcFunc['db_fetch_assoc']($request);
    $smcFunc['db_free_result']($request);

    // Though the topic should be there, it might have vanished.
    if (!is_array($topic_info))
        fatal_lang_error('topic_doesnt_exist');

    // Did this topic suddenly move? Just checking...
    if ($topic_info['id_board'] != $board)
        fatal_lang_error('not_a_topic');

    // Get a response prefix (like 'Re:') in the default forum language.
    if (!isset($context['response_prefix']) && !($context['response_prefix'] = cache_get_data('response_prefix')))
    {
        if ($language === $user_info['language'])
            $context['response_prefix'] = $txt['response_prefix'];
        else
        {
            loadLanguage('index', $language, false);
            $context['response_prefix'] = $txt['response_prefix'];
            loadLanguage('index');
        }
        cache_put_data('response_prefix', $context['response_prefix'], 600);
    }
    if (trim($context['response_prefix']) != '' && $topic_info['subject'] != '' && $smcFunc['strpos']($topic_info['subject'], trim($context['response_prefix'])) !== 0)
        $_POST['subject'] = $context['response_prefix'] . $topic_info['subject'];
    
}

function before_action_save_raw_post()
{
    check_topic_notify();
}

function check_topic_notify()
{
    global $smcFunc, $topic, $user_info;

    if (!$topic || !isset($user_info['id'])) return;

    $request = $smcFunc['db_query']('', '
        SELECT IFNULL(id_topic, 0) AS notify
        FROM {db_prefix}log_notify
        WHERE id_topic = {int:current_topic} and id_member = {int:current_member}
        LIMIT 1',
        array(
            'current_member' => $user_info['id'],
            'current_topic' => $topic,
        )
    );
    list ($notify) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    $_POST['notify'] = !empty($notify);
}

function before_action_authorize_user()
{
    global $smcFunc, $request_params, $sc;

    $_POST['hash_passwrd'] = sha1(sha1(($smcFunc['db_case_sensitive'] ? $_REQUEST['user'] : strtolower($_REQUEST['user'])).$request_params[1]).$sc);
    $_REQUEST['hash_passwrd'] = $_POST['hash_passwrd'];
}

function before_action_login()
{
    global $smcFunc, $request_params, $sc;

    $_POST['hash_passwrd'] = sha1(sha1(($smcFunc['db_case_sensitive'] ? $_REQUEST['user'] : strtolower($_REQUEST['user'])).$_REQUEST['password']).$sc);
    $_REQUEST['hash_passwrd'] = $_POST['hash_passwrd'];
}

function before_action_login_mod()
{
    global $smcFunc, $request_params, $sc;

    $_POST['admin_hash_pass'] = sha1(sha1(($smcFunc['db_case_sensitive'] ? $_REQUEST['user'] : strtolower($_REQUEST['user'])).$_REQUEST['password']) . $sc);
    $_REQUEST['admin_hash_pass'] = $_POST['admin_hash_pass'];
}

function before_action_search()
{
    global $smcFunc, $search_filter, $context;

    //$context['showposts'] = isset($_POST['showposts']) ? $_POST['showposts'] : 1;

    // Specify user name by user id
    if (isset($search_filter['userid']) && !empty($search_filter['userid']))
    {
        $request = $smcFunc['db_query']('', '
            SELECT member_name
            FROM {db_prefix}members
            WHERE id_member = {int:member_id}',
        array(
            'member_id' => $search_filter['userid'])
        );
        while ($row = $smcFunc['db_fetch_assoc']($request))
        {
            $_POST['userspec'] = $row['member_name'];
            $_REQUEST['userspec'] = $_POST['userspec'];
        }
    }
    
    // Specify board:
    if (!isset($search_filter['forumid']) || empty($search_filter['forumid']))
    {
        $_POST['brd'] = array();
        if (isset($search_filter['only_in']) && is_array($search_filter['only_in']) && !empty($search_filter['only_in']))
        {
            $_POST['brd'] = array_map('intval', $search_filter['only_in']);;
        }
        else
        {
            $brd_request = $smcFunc['db_query']('order_by_board_order', '
                SELECT b.id_board
                FROM {db_prefix}boards AS b
                WHERE {query_see_board}
                    AND redirect = {string:empty_string}',
                array(
                    'empty_string' => '',
                )
            );
            while ($row = $smcFunc['db_fetch_assoc']($brd_request))
            {
                $_POST['brd'][] = $row['id_board'];
            }
        }
        
        // Remove not_in board.
        if (isset($search_filter['not_in']) && !empty($search_filter['not_in']) && is_array($search_filter['not_in']))
        {
            $_POST['brd'] = array_diff($_POST['brd'], array_map('intval', $search_filter['not_in']));
        }
        
        $_REQUEST['brd'] = $_POST['brd'];
    }
}

function before_action_update_push_status()
{
    global $user_info;

    if ($user_info['id'])
    {
        $_POST['action'] = 'update_push_status';
        $_REQUEST['action'] = $_POST['action'];
    }
    else
    {
        before_action_login();
    }
}

function before_action_get_thread()
{
    global $smcFunc, $user_info, $modSettings, $context, $user_settings, $topic;
    
    //Okay let's Check an prepare ;)
    $context['user_post_avaible'] = 0; //Standard Show no hidden content ;)
    //Only a Member Thing ;)
    if (!$user_info['is_guest']) {
        $check_for_hide = true;

  //Groupcheck ;D
        if($check_for_hide && !empty($modSettings['hide_autounhidegroups'])) {
            $modSettings['hide_autounhidegroups'] = !is_array($modSettings['hide_autounhidegroups']) ? explode(',', $modSettings['hide_autounhidegroups']) : $modSettings['hide_autounhidegroups'];
            foreach($user_info['groups'] as $group_id)
                if(in_array($group_id, $modSettings['hide_autounhidegroups'])) {
                    $check_for_hide = false;
                    $context['user_post_avaible'] = 1;
                    break; //One is enouph ;D
                }
        }

        $karmaOk = false;
        $postOk = false;

        //Okay know let's look for the post minimum ;D
        if($check_for_hide && (!empty($modSettings['hide_minpostunhide']) || !empty($modSettings['hide_minpostautounhide']))) {
            //Load the posts data ;D
            global $user_settings;

            //Need a minimum post to unhide?
            if(!empty($modSettings['hide_minpostunhide']) && $modSettings['hide_minpostunhide'] > 0 && $user_settings['posts'] < $modSettings['hide_minpostunhide']) {
                $postOk = true;
                $check_for_hide = false;
            }

            //Auto Unhide????
            if(!empty($modSettings['hide_minpostautounhide']) && $modSettings['hide_minpostautounhide'] > 0 && $user_settings['posts'] > $modSettings['hide_minpostautounhide']) {
                    $check_for_hide = false;
                    $context['user_post_avaible'] = 1;
            }

        }
        else
            $postOk = true;

        //Okay Check Karma Things :)
        if(!empty($modSettings['karmaMode']) && $check_for_hide && !empty($modSettings['hide_karmaenable'])) {
            //Karma Check :D for this i need to load the user infos :x
            loadMemberData($user_info['id']);
            loadMemberContext($user_info['id']);
            global $memberContext;

            if(!empty($modSettings['hide_onlykarmagood']))
                $karmaValue = $memberContext[$user_info['id']]['karma']['good'];
            else
                $karmaValue = $memberContext[$user_info['id']]['karma']['good'] - $memberContext[$user_info['id']]['karma']['bad'];

            //Need a minimum karma to unhide?
            if(!empty($modSettings['hide_minkarmaunhide']) && $karmaValue < $modSettings['hide_minkarmaunhide']) {
                $check_for_hide = false;
                $karmaOk = true;
            }

            //Auto Unhide for Karma?
            if(!empty($modSettings['hide_minkarmaautounhide']) && $karmaValue > $modSettings['hide_minkarmaautounhide']) {
                    $check_for_hide = false;
                    $context['user_post_avaible'] = 1;
            }

        }
        else
            $karmaOk = true;

        // Find if there a post from you in this thread :) (For the hide tag, at least one Post need to be approved!)
        if (empty($context['user_post_avaible']) && $check_for_hide) {
            $request = $smcFunc['db_query']('', '
                SELECT id_msg, id_member, approved
                FROM {db_prefix}messages
                    WHERE id_topic = {int:topic}
                    AND id_member = {int:id_member}
                    AND approved = {int:approved}
                LIMIT {int:limit}',
                array(
                    'id_member' => $user_info['id'],
                    'topic' => $topic,
                    'limit' => 1,
                    'approved' => 1,
                )
            );

            if ($smcFunc['db_num_rows']($request)) 
                $context['user_post_avaible'] = 1;
            else 
                $context['user_post_avaible'] = 0;
            $smcFunc['db_free_result']($request);
        }
    }
}

function before_action_admin_invite()
{
    global $boardurl, $sourcedir, $smcFunc;
    
    require_once('include/PHPMailer/class.phpmailer.php');
    require_once($sourcedir . '/Subs-Post.php');
    $exttMbqBoardUrl = preg_replace('/(.*?)\/mobiquo/i', '$1', $boardurl);
    
    //refer vb40 invitation.php
    error_reporting(0);
    ini_set('max_execution_time', '120');
    
    $invite_response['result'] = false;
    if(!empty($_POST['session']) && !empty($_POST['api_key']) && !empty($_POST['subject']) && !empty($_POST['body']))
    {
        $push_url = "http://tapatalk.com/forum_owner_invite.php?PHPSESSID=$_POST[session]&api_key=$_POST[api_key]&url=".urlencode($exttMbqBoardUrl)."&action=verify";
        //$response = getContentFromRemoteServer($push_url, 10, $error, 'POST');
        $response = getContentFromRemoteServer($push_url, 10, $error, 'GET');
        //$_POST['subject'] = mobiquo_encode($_POST['subject'],'to_local');
        //$_POST['body'] = mobiquo_encode($_POST['body'],'to_local');
        if($response) $result = @ json_decode($response, true);
        if(empty($result) || empty($result['result']))
            if(preg_match('/\{"result":true/', $response))
                $result = array('result' => true);
        if(isset($result) && isset($result['result']) && $result['result'])
        {
            if(isset($_POST['username']))
            {   //send email to someone
                if(!empty($_POST['username']))
                {
                    if ($user = get_user_by_name_or_email($_POST['username'])) {
                    } else {
                        $user = get_user_by_name_or_email($_POST['username'], true);
                    }
                    if ($user && ($user['is_activated'] == 1) && $user['email_address']) {
                        $invite_response['result'] = exttmbq_sendmail($user['email_address'], $_POST['subject'], $_POST['body']) ? true : false;
                        $invite_response['result_text'] = "Sent successfully for $_POST[username]";
                    } else {
                        //$invite_response['result_text'] = 'Username does not exist or user don\'t allow admin emails!';
                        $invite_response['result_text'] = 'Username does not exist or is not valid.';
                    }
                }
                else
                {
                    $invite_response['result_text'] = 'Username does not exist!';
                }
            }
            else
            {   //send email to all
                $request = $smcFunc['db_query']('', "
                    SELECT 
                        *
                    FROM {db_prefix}members AS m
                    WHERE
                        m.is_activated = 1 AND m.email_address <> ''"
                );
                $number = 0;
                while($r = $smcFunc['db_fetch_assoc']($request))
                {
                    if (exttmbq_sendmail($r['email_address'], $_POST['subject'], $_POST['body'])) {
                        $number++;
                    }
                }
                $smcFunc['db_free_result']($request);
                
                $invite_response['result'] = $number ? true : false;
                $invite_response['number'] = $number;
                $invite_response['result_text'] = "Sent email to $number users";
            }
        }
        else
        {
            $invite_response['result_text'] = $error ? $error : 'Verify failed.';
        }
    }
    else if(!empty($_POST['email_target']))
    {
        $request = $smcFunc['db_query']('', "
            SELECT 
                COUNT(*) as c
            FROM {db_prefix}members AS m
            WHERE
                m.is_activated = 1 AND m.email_address <> ''"
        );
        $r = $smcFunc['db_fetch_assoc']($request);
        $smcFunc['db_free_result']($request);
        $user_count = $r['c'];
        echo $user_count;
        exit;
    }
    
    header('Content-type: application/json');
    echo @ json_encode($invite_response);
    exit;
}

function after_action_get_topic()
{
    global $context, $smcFunc, $user_info, $subscribed_tids;

    $subscribed_tids = array();
    $topic_ids = array_keys($context['topics']);
    if (!empty($topic_ids))
    {
        $request = $smcFunc['db_query']('', '
            SELECT id_topic
            FROM {db_prefix}log_notify
            WHERE id_topic IN ({array_int:topic_list})
                AND id_member = {int:current_member}',
            array(
                'current_member' => $user_info['id'],
                'topic_list' => $topic_ids,
            )
        );

        while ($row = $smcFunc['db_fetch_assoc']($request))
            $subscribed_tids[] = $row['id_topic'];
    }
}

function after_action_login()
{
    //Add by tapatalk
    global $request_params, $user_info, $modSettings;
    if (isset($request_params[3]) && $request_params[3]) 
        update_push();

    if(isset($modSettings['tp_allow_usergroup']) && !empty($modSettings['tp_allow_usergroup']))
    {
        $allow_tapatalk = false;
        $allow_usergroups = explode(',', $modSettings['tp_allow_usergroup']);
        foreach($user_info['groups'] as $group_id)
        {
            if(in_array($group_id, $allow_usergroups))
                $allow_tapatalk = true;
        }
        if(!$allow_tapatalk)
            get_error('You are not allowed to login via Tapatalk, please contact your forum administrator.');
    }
}

function after_action_m_ban_user()
{
    // delete user's topics and posts after ban
    if ($_POST['mode'] == 2)
    {
        $_GET['action'] = 'profile';
        $_GET['area'] = 'deleteaccount';
        $_GET['save'] = 1;
        $_POST['remove_type'] = 'topics';
        $_POST['u'] = $_POST['bannedUser'];
        $_POST['sa'] = 'deleteaccount';
        $_REQUEST['action'] = 'profile';
        $_REQUEST['u'] = $_POST['bannedUser'];
        $_REQUEST['area'] = 'deleteaccount';
        $_REQUEST['remove_type'] = 'topics';
        $_REQUEST['sa'] = 'deleteaccount';
        $_REQUEST['save'] = 1;
        require_once('include/Profile.php');
        ModifyProfile();
    }
}

function before_action_m_ban_user()
{
    global $txt, $smcFunc;

    $request = $smcFunc['db_query']('', '
        SELECT id_member, email_address
        FROM {db_prefix}members
        WHERE member_name = {string:current_member} OR real_name = {string:current_member}',
        array(
            'current_member' => $_POST['ban_name'],
        )
    );
    list ($id_member, $email_address) = $smcFunc['db_fetch_row']($request);
    $smcFunc['db_free_result']($request);

    if ($id_member)
    {
        $_POST['email'] = $email_address;
        $_POST['bannedUser'] = $id_member;
    }
    else
        fatal_lang_error('invalid_username', false);
}

function before_action_m_move_post()
{
    //prepare entry parameters begin
    global $request_params;
    
    if ($post = exttMbqGetPost($request_params[0])) {
        if ($topic = exttMbqGetTopic($post['id_topic'])) {
            $_GET['topic'] = $post['id_topic'];
            $GLOBALS['topic'] = $post['id_topic'];  //used for $sourcedir/SplitTopics.php->SplitTopics()
        } else {
            get_error('Need valid topic when move post.');
        }   
    } else {
        get_error('Need valid post id when move post.');
    }
    //prepare entry parameters end
}

function before_action_update_password()
{
    global $sourcedir, $modSettings, $cur_profile, $user_info, $language;

    if(isset($_POST['old_password']))
    {
        $cur_profile['member_name'] = $user_info['username'];
        $cur_profile['real_name'] =  $user_info['name'];
        $cur_profile['email_address'] =  $user_info['email'];
        $cur_profile['id_member'] =  $user_info['id'];
        //action 1: from profile clue.

        // Since the password got modified due to all the $_POST cleaning, lets undo it so we can get the correct password
        $_POST['old_password'] = un_htmlspecialchars($_POST['old_password']);

        // Does the integration want to check passwords?
        $good_password = in_array(true, call_integration_hook('integrate_verify_password', array($cur_profile['member_name'], $_POST['old_password'], false)), true);

        // Bad password!!!
        if (!$good_password && $user_info['passwd'] != sha1(strtolower($cur_profile['member_name']) . $_POST['old_password']))
            fatal_lang_error('profile_error_bad_password', false);
    }
    else
    {
        //action 2: from email part.
        if(!isset($modSettings['tp_push_key']) || empty($modSettings['tp_push_key']))
            get_error('Forum is not configured well, please contact administrator to set up push key for the forum!');

        $email_response = getEmailFromScription($_POST['token'], $_POST['code'], $modSettings['tp_push_key']);
        if(empty($email_response))
            get_error('Failed to connect to tapatalk server, please try again later.');
        if( !$email_response['result']|| (!isset($email_response['email']) || empty($email_response['email'])))
            get_error('You need to input an email or re-login tapatalk id to use default email of tapatalk id.');

        require_once($sourcedir . '/Subs-Members.php');
        $member = list_getMembers(0, 30, 'member_name', '(email_address = {string:email_normal})', array('email_normal' => $email_response['email']));
        if(!isset($member[0]['id_member']) || empty($member[0]['id_member']))
            get_error('no email user found.');
            
        $cur_profile = $member[0];
    }
}

function action_update_password()
{
    global $cur_profile, $sourcedir;

    require_once($sourcedir . '/Subs-Auth.php');
    $passwordErrors = validatePassword($_POST['new_password'], $cur_profile['member_name'], array($cur_profile['real_name'], $cur_profile['email_address']));
    // Were there errors?
    if ($passwordErrors != null)
        fatal_lang_error('profile_error_password_' . $passwordErrors);
    $passwd = sha1(strtolower($cur_profile['member_name']) . un_htmlspecialchars($_POST['new_password']));
    updateMemberData($cur_profile['id_member'], array('passwd' => $passwd));

}

function before_action_update_email()
{
    global $user_info;

    if(!isset($user_info['id']) || empty($user_info['id']))
        get_error('You must login to do that.');
    if($user_info['email'] == $_POST['email_address'])
        get_error('New email cannot be the same with orignial one.');
    $_REQUEST['real_name'] = $_POST['real_name'] = $user_info['name'];
    $_REQUEST['u'] = $_POST['u'] = $user_info['id'];
    $_REQUEST['save'] = true;
}

function before_action_forget_password()
{
    global $modSettings;

    if(isset($_POST['token']))
    {
        if(!isset($modSettings['tp_push_key']) || empty($modSettings['tp_push_key']))
            get_error('Forum is not configured well, please contact administrator to set up push key for the forum!');

        $email_response = getEmailFromScription($_POST['token'], $_POST['code'], $modSettings['tp_push_key']);

        if(empty($email_response))
            get_error('Failed to connect to tapatalk server, please try again later.');

        $_POST['email'] = isset($email_response['email']) && !empty($email_response['email']) ? $email_response['email'] : false;
        $_POST['verified'] = isset($email_response['result']) && $email_response['result'];
    }
}
function action_forget_password()
{
    global $smcFunc, $context, $sourcedir, $scripturl;

    checkSession();
    $where = '';
    $where_params = array();
    // Coming with a known ID?
    if(isset($_POST['username']) && $_POST['username'] != '')
    {
        $where = 'member_name = {string:member_name}';
        $where_params['member_name'] = $_POST['username'];
        $where_params['email_address'] = isset($_POST['email']) ? $_POST['email'] : '';
    }

    // You must enter a username/email address.
    if (empty($where))
        fatal_lang_error('username_no_exist', false);

    // Find the user!
    $request = $smcFunc['db_query']('', '
        SELECT id_member, real_name, member_name, email_address, is_activated, validation_code, lngfile, openid_uri, secret_question
        FROM {db_prefix}members
        WHERE ' . $where . '
        LIMIT 1',
        array_merge($where_params, array(
        ))
    );
    $row = $smcFunc['db_fetch_assoc']($request);
    if(empty($row))
        fatal_lang_error('username_no_exist', true);
    if(isset($_POST['verified']) && $_POST['verified'] && $row['email_address'] == $_POST['email'])
    {
        $_POST['reminder_type'] = 'no-reminder';
    }
    else{
        $_POST['reminder_type'] = 'email';
        $_POST['verified'] = false;

    }
    // find the user?
    if ($smcFunc['db_num_rows']($request) == 0)
        fatal_lang_error('username_no_exist', false);

    $context['account_type'] = !empty($row['openid_uri']) ? 'openid' : 'password';

    // If the user isn't activated/approved, give them some feedback on what to do next.
    if ($row['is_activated'] != 1)
    {
        loadLanguage('Profile');
        // Awaiting approval...
        if (trim($row['validation_code']) == '')
            fatal_error(mobi_lang('registration_not_approved'), false);
        else
            fatal_error(mobi_lang('registration_not_activated'), false);
    }

    // You can't get emailed if you have no email address.
    $row['email_address'] = trim($row['email_address']);
    if ($row['email_address'] == '')
        fatal_error($txt['no_reminder_email'] . '<br />' . $txt['send_email'] . ' <a href="mailto:' . $webmaster_email . '">webmaster</a> ' . $txt['to_ask_password'] . '.');

    // If they have no secret question then they can only get emailed the item, or they are requesting the email, send them an email.
    if ($_POST['reminder_type'] == 'email')
    {
        // Randomly generate a new password, with only alpha numeric characters that is a max length of 10 chars.
        require_once($sourcedir . '/Subs-Members.php');
        $password = generateValidationCode();

        require_once($sourcedir . '/Subs-Post.php');
        $replacements = array(
            'REALNAME' => $row['real_name'],
            'REMINDLINK' => $scripturl . '?action=reminder;sa=setpassword;u=' . $row['id_member'] . ';code=' . $password,
            'IP' => $user_info['ip'],
            'MEMBERNAME' => $row['member_name'],
            'OPENID' => $row['openid_uri'],
        );

        $emaildata = loadEmailTemplate('forgot_' . $context['account_type'], $replacements, empty($row['lngfile']) || empty($modSettings['userLanguage']) ? $language : $row['lngfile']);
        $context['description'] = $txt['reminder_' . (!empty($row['openid_uri']) ? 'openid_' : '') . 'sent'];

        // If they were using OpenID simply email them their OpenID identity.
        $mail_result = sendmail($row['email_address'], $emaildata['subject'], $emaildata['body'], null, null, false, 0);
        if (empty($row['openid_uri']))
            // Set the password in the database.
            updateMemberData($row['id_member'], array('validation_code' => substr(md5($password), 0, 10)));

        // Set up the template.
        $context['sub_template'] = 'sent';
        $_POST['result_text'] = $mail_result ? '' : 'Failed to send confirmation email';
        $_POST['result'] = $mail_result;
    }
}

function after_action_create_message()
{
    global $context;
    
    if (!empty($context['send_log']['failed']))
        foreach($context['send_log']['failed'] as $error_text)
            get_error($error_text);
}

function before_action_new_topic()
{
    if(empty($_POST['message']))
        fatal_lang_error('error_no_message');
    if(empty($_POST['subject']))
        fatal_lang_error('error_no_subject');
}

function before_action_prefetch_account()
{
    $user = get_user_by_name_or_email($_GET['email'] , true);
    $_REQUEST['u'] = $_POST['u'] = $_GET['u'] = isset($user['id_member']) && !empty($user['id_member']) ? $user['id_member'] : 0;
}

function action_prefetch_account()
{
}

function action_search_user()
{
    global $smcFunc, $user_info, $user_lists, $user_profile, $modSettings, $settings, $scripturl;
    
    $_REQUEST['search'] = trim($smcFunc['strtolower']($_REQUEST['search'])) . '*';
    $_REQUEST['search'] = strtr($_REQUEST['search'], array('%' => '\%', '_' => '\_', '*' => '%', '?' => '_', '&#038;' => '&amp;'));

    // Find the member.
    $request = $smcFunc['db_query']('', '
        SELECT id_member, real_name
        FROM {db_prefix}members
        WHERE real_name LIKE {string:search}' . (!empty($context['search_param']['buddies']) ? '
            AND id_member IN ({array_int:buddy_list})' : '') . '
            AND is_activated IN (1, 11)
        LIMIT ' . ($smcFunc['strlen']($_REQUEST['search']) <= 2 ? '100' : '800'),
        array(
            'buddy_list' => $user_info['buddies'],
            'search' => $_REQUEST['search'],
        )
    );

    $user_lists = array();

    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        $avatar = '';
        $row['real_name'] = strtr($row['real_name'], array('&amp;' => '&#038;', '&lt;' => '&#060;', '&gt;' => '&#062;', '&quot;' => '&#034;'));
        
        loadMemberData($row['id_member']);
        $profile = $user_profile[$row['id_member']];
        if (!empty($settings['show_user_images']) && empty($profile['options']['show_no_avatars']))
            $avatar = $profile['avatar'] == '' ? ($profile['id_attach'] > 0 ? (empty($profile['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $profile['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $profile['filename']) : '') : (stristr($profile['avatar'], 'http://') ? $profile['avatar'] : $modSettings['avatar_url'] . '/' . $profile['avatar']);
        else
            $avatar = '';
        $user_lists[] = array(
            'username' => $row['real_name'],
            'userid' => $row['id_member'],
            'icon_url' => $avatar,
        );
    }
    $smcFunc['db_free_result']($request);
}

function action_ignore_user()
{
    global $txt, $scripturl, $modSettings, $user_info;
    global $context, $user_profile, $memberContext, $smcFunc;
    
    // For making changes!
    $ignoreArray = $user_info['ignoreusers'];


    // Removing a member from the ignore list?
    if (isset($_GET['remove']) && $user_info['id'])
    {
        checkSession('get');

        // Heh, I'm lazy, do it the easy way...
        foreach ($ignoreArray as $key => $id_remove)
            if ($id_remove == (int) $_GET['remove'])
                unset($ignoreArray[$key]);

        // Make the changes.
        $ignore_list = implode(',', $ignoreArray);
        updateMemberData($memID, array('pm_ignore_list' => $ignore_list));

        // Redirect off the page because we don't like all this ugly query stuff to stick in the history.
    }
    elseif (isset($_POST['new_ignore']) && $_POST['new_ignore'] && $user_info['id'])
    {

        // Now find out the id_member for the members in question.
        $request = $smcFunc['db_query']('', '
            SELECT id_member
            FROM {db_prefix}members
            WHERE id_member = {int:new_ignore}',
            array(
                'new_ignore' => $_POST['new_ignore'],
            )
        );

        // Add the new member to the buddies array.
        while ($row = $smcFunc['db_fetch_assoc']($request))
            $ignoreArray[] = (int) $row['id_member'];
        $smcFunc['db_free_result']($request);

        // Now update the current users buddy list.
        $ignore_list = implode(',', $ignoreArray);
        updateMemberData($memID, array('pm_ignore_list' => $ignore_list));
    }
}

function action_get_recommended_user()
{
    global $context, $user_info, $smcFunc;

    if(empty($user_info['id']))
    {
        $context['recommend'] = array();
        return;
    }
    $user_lists = array();

    //add_watched_your_thread_users
    $thread_ids = array();
    $request = $smcFunc['db_query']('', '
        SELECT t.id_topic
        FROM {db_prefix}topics as t
        WHERE t.id_member_started = {int:current_member}
            AND approved = 1',
        array(
            'current_member' => $user_info['id']
        )
    );
    while ($row = $smcFunc['db_fetch_assoc']($request))
    {
        $thread_ids[] = $row['id_topic'];
    }
    //fix bug:Database error, given array of integer values is empty. (topic_list)
    if (!$thread_ids) {
        $thread_ids[] = '2000000000';   //impossible big integer
    }
    $request_members = $smcFunc['db_query']('', '
        SELECT
            ln.id_member 
        FROM {db_prefix}log_notify as ln
        WHERE ln.id_topic IN ({array_int:topic_list})',
        array(
            'topic_list' => $thread_ids,
        )
    );
    while ($row = $smcFunc['db_fetch_assoc']($request_members))
    {
        $user_lists = merge_users($user_lists, array($row['id_member'] => 3));
    }

    //add_thread_watch_users
    $request_members = $smcFunc['db_query']('', '
        SELECT
            t.id_member_started
        FROM {db_prefix}log_notify ln 
        LEFT JOIN {db_prefix}topics t ON (ln.id_topic = t.id_topic)
        WHERE ln.id_member = {int:current_member}',
        array(
            'current_member' => $user_info['id'],
        )
    );
    while ($row = $smcFunc['db_fetch_assoc']($request_members))
    {
        if(!empty($row['id_member_started']))
            $user_lists = merge_users($user_lists, array($row['id_member_started']=> 3));
    }

    //add_coversation_users
    $request_members = $smcFunc['db_query']('', '
        SELECT pmr.id_member
        FROM {db_prefix}personal_messages pm
        LEFT JOIN {db_prefix}pm_recipients pmr ON (pmr.id_pm = pm.id_pm)
        WHERE pm.id_member_from = {int:current_member}',
        array(
            'current_member' => $user_info['id'],
        )
    );
    while ($row = $smcFunc['db_fetch_assoc']($request_members))
    {
        if(!empty($row['id_member']))
            $user_lists = merge_users($user_lists, array($row['id_member']=> 10));
    }

    //add buddy list users
    $request_buddys = $smcFunc['db_query']('', '
        SELECT buddy_list
        FROM {db_prefix}members
        WHERE id_member = {int:current_member}',
        array(
            'current_member' => $user_info['id'],
        )
    );
    while ($row = $smcFunc['db_fetch_assoc']($request_buddys))
    {
        if(!empty($row['buddy_list']))
            $users = explode(',', $row['buddy_list']);
                foreach($users as $user)
                    if(!empty($user))
                        $user_lists = merge_users($user_lists, array($user => 5));
    }

    $context['recommend'] = $user_lists;
}

function action_get_contact()
{
}
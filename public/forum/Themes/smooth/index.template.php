<?php
// Version: 2.0.2; index

/* 	This theme is released on Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License,
	you are free to alter the theme	to suit your site, you are not allowed to 
	redstribute it without approval, or remove the author copyright without paying 
	for copyright removal	
*/

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

// Initialize the template... mainly little settings.
function template_init()
{
    global $context, $settings, $options, $txt;

    /* Use images from default theme when using templates from the default theme?
      if this is 'always', images from the default theme will be used.
      if this is 'defaults', images from the default theme will only be used with default templates.
      if this is 'never' or isn't set at all, images from the default theme will not be used. */
    $settings['use_default_images'] = 'never';

    /* What document type definition is being used? (for font size and other issues.)
      'xhtml' for an XHTML 1.0 document type definition.
      'html' for an HTML 4.01 document type definition. */
    $settings['doctype'] = 'xhtml';

    /* The version this template/theme is for.
      This should probably be the version of SMF it was created for. */
    $settings['theme_version'] = '2.0.2';

    /* Set a setting that tells the theme that it can render the tabs. */
    $settings['use_tabs'] = true;

    /* Use plain buttons - as opposed to text buttons? */
    $settings['use_buttons'] = true;

    /* Show sticky and lock status separate from topic icons? */
    $settings['separate_sticky_lock'] = true;

    /* Does this theme use the strict doctype? */
    $settings['strict_doctype'] = false;

    /* Does this theme use post previews on the message index? */
    $settings['message_index_preview'] = false;

    /* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
    $settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    // Show right to left and the character set for ease of translating.
    echo '<!DOCTYPE html><head>';

    // The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
    echo '
	<link rel="stylesheet" href="../../../dist/zbw.min.css">
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />';

    // Some browsers need an extra stylesheet due to bugs/compatibility issues.
    /*	foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
        if ($context['browser']['is_' . $cssfix])
          echo '
      <link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';*/

    // RTL languages require an additional stylesheet.
    if ($context['right_to_left']) {
        echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';
    }

    // Here comes the JavaScript bits!
    echo '
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/theme.js?fin20"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>';

    echo '
	<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
	<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
	<title>', $context['page_title_html_safe'], '</title>';

    // Please don't index these Mr Robot.
    if (!empty($context['robot_no_index'])) {
        echo '
	<meta name="robots" content="noindex" />';
    }

    // Present a canonical url for search engines to prevent duplicate content in their indices.
    if (!empty($context['canonical_url'])) {
        echo '
	<link rel="canonical" href="', $context['canonical_url'], '" />';
    }

    // Show all the relative links, such as help, search, contents, and the like.
    echo '
	<link rel="help" href="', $scripturl, '?action=help" />
	<link rel="search" href="', $scripturl, '?action=search" />
	<link rel="contents" href="', $scripturl, '" />';

    // If RSS feeds are enabled, advertise the presence of one.
    if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged'])) {
        echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';
    }

    // If we're viewing a topic, these should be the previous and next topics, respectively.
    if (!empty($context['current_topic'])) {
        echo '
	<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev" />
	<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next" />';
    }

    // If we're in a board, or a topic for that matter, the index will be the board's index.
    if (!empty($context['current_board'])) {
        echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';
    }

    // Output any remaining HTML headers. (from mods, maybe?)
    echo $context['html_headers'];

    echo '
</head>
<body>';
}

function template_body_above()
{
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    echo !empty($settings['forum_width']) ? '
<div id="wrapper" style="width: ' . $settings['forum_width'] . '">' : '', '
	<div id="header">
		<div id="upper_section">
				<div class="user">';

    // If the user is logged in, display stuff like their name, new messages, etc.
    if ($context['user']['is_logged']) {
        if (!empty($context['user']['avatar'])) {
            echo '
				<p class="avatar">', $context['user']['avatar']['image'], '</p>';
        }
        echo '
				<ul class="reset">
					<li class="greeting">', $txt['hello_member_ndt'], ' <span>', $context['user']['name'], '</span></li>
					<li><a href="', $scripturl, '?action=unread">', $txt['unread_since_visit'], '</a></li>
					<li><a href="', $scripturl, '?action=unreadreplies">', $txt['show_unread_replies'], '</a></li>';

        // Is the forum in maintenance mode?
        if ($context['in_maintenance'] && $context['user']['is_admin']) {
            echo '
					<li class="notice">', $txt['maintain_mode_on'], '</li>';
        }

        // Are there any members waiting for approval?
        if (!empty($context['unapproved_members'])) {
            echo '
					<li>', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' <a href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve">', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], '</a> ', $txt['approve_members_waiting'], '</li>';
        }

        if (!empty($context['open_mod_reports']) && $context['show_open_reports']) {
            echo '
					<li><a href="', $scripturl, '?action=moderate;area=reports">', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '</a></li>';
        }

        echo '
					<li>', $context['current_time'], '</li>
				</ul>';
    }
    echo '
			</div>
			<div class="news normaltext">';
    // Show a random news item? (or you could pick one from news_lines...)
    if (!empty($settings['enable_news'])) {
        echo '
				<h2>', $txt['news'], ': </h2>
				<p>', $context['random_news_line'], '</p>';
    }

    echo '
			</div>
		</div></div>';

    // Show the menu here, according to the menu sub template.
    template_menu();

    echo '
		<br class="clear" />';

    // The main content should go here.
    echo '
	<div id="content_section"><div>
		<div><br />';

    // Custom banners and shoutboxes should be placed here, before the linktree.
    //PLEASE NOTE: this is area for an advertisement
    dt();
    // Show the navigation tree.
    theme_linktree();
}

function template_body_below()
{
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    echo '
		</div>';
    //PLEASE NOTE: this is area for an advertisement
    dt1();
    echo '
	</div></div>';

    // Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
    echo '
	<div id="footer_section"><div><img id="decalf" src="' . $settings['images_url'] . '/theme/footer_decal.jpg" alt="" title="" />
		<ul class="reset">
			<li class="copyright">', theme_copyright(), '</li>
						<li class="copyright"><strong>Smooth:</strong> by <a href="http://www.smfhacks.com" target="_blank">SMFHacks.com - SMF Mods</a></li>';
    if (!empty($settings['cc_control'])) {
        echo '
			<li>', !empty($settings['cc']) ? '' . parse_bbc($settings['cc']) . '' : '', '</li>';
    }
    echo '
			<li class="copyright">',
    !empty($settings['t_policy']) ? '<a href="' . $settings['t_policy'] . '" title="' . $txt['t_policy'] . '">' . $txt['t_policy'] . '</a>' : '',
    !empty($settings['t_terms']) ? ' <a href="' . $settings['t_terms'] . '" title="' . $txt['t_terms'] . '">' . $txt['t_terms'] . '</a>' : '',
    !empty($settings['t_contact']) ? ' <a href="' . $settings['t_contact'] . '" title="' . $txt['t_contact'] . '">' . $txt['t_contact'] . '</a>' : '',
    '</li>
<li><a id="button_xhtml" href="http://validator.w3.org/check/referer" target="_blank" class="new_win" title="', $txt['valid_xhtml'], '"><span>', $txt['xhtml'], '</span></a></li>
			', !empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']) ? '<li><a id="button_rss" href="' . $scripturl . '?action=.xml;type=rss" class="new_win"><span>' . $txt['rss'] . '</span></a></li>' : '', '
			<li class="last"><a id="button_wap2" href="', $scripturl, '?wap2" class="new_win"><span>', $txt['wap2'], '</span></a></li>
		</ul>';

    // Show the load time?
    if ($context['show_load_time']) {
        echo '
		<p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';
    }

    echo '
	</div></div>', !empty($settings['forum_width']) ? '
</div>' : '';
}

function template_html_below()
{
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false)
{
    global $context, $settings, $options, $shown_linktree;

    // If linktree is empty, just return - also allow an override.
    if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show)) {
        return;
    }

    echo '
	<div class="navigate_section">
		<ul>';

    // Each tree item has a URL and name. Some may have extra_before and extra_after.
    foreach ($context['linktree'] as $link_num => $tree) {
        echo '
			<li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

        // Show something before the link?
        if (isset($tree['extra_before'])) {
            echo $tree['extra_before'];
        }

        // Show the link, including a URL if it should have one.
        echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

        // Show something after the link...?
        if (isset($tree['extra_after'])) {
            echo $tree['extra_after'];
        }

        // Don't show a separator for the last one.
        if ($link_num != count($context['linktree']) - 1) {
            echo ' &#187;';
        }

        echo '
			</li>';
    }
    echo '
		</ul>
	</div>';

    $shown_linktree = true;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
    global $context, $settings, $options, $scripturl, $txt;

    echo '
		<div id="main_menu">
			<ul class="dropmenu">';

    foreach ($context['menu_buttons'] as $act => $button) {
        echo '
				<li id="button_', $act, '">
					<a class="', $button['active_button'] ? 'active ' : '', 'firstlevel" href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>
						<span class="', isset($button['is_last']) ? 'last ' : '', 'firstlevel">', $button['title'], '</span>
					</a>';
        if (!empty($button['sub_buttons'])) {
            echo '
					<ul>';

            foreach ($button['sub_buttons'] as $childbutton) {
                echo '
						<li>
							<a href="', $childbutton['href'], '"', isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
								<span', isset($childbutton['is_last']) ? ' class="last"' : '', '>', $childbutton['title'], !empty($childbutton['sub_buttons']) ? '...' : '', '</span>
							</a>';
                // 3rd level menus :)
                if (!empty($childbutton['sub_buttons'])) {
                    echo '
							<ul>';

                    foreach ($childbutton['sub_buttons'] as $grandchildbutton) {
                        echo '
								<li>
									<a href="', $grandchildbutton['href'], '"', isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
										<span', isset($grandchildbutton['is_last']) ? ' class="last"' : '', '>', $grandchildbutton['title'], '</span>
									</a>
								</li>';
                    }

                    echo '
							</ul>';
                }

                echo '
						</li>';
            }
            echo '
					</ul>';
        }
        echo '
				</li>';
    }

    echo '
			</ul>
		</div>';
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
    global $settings, $context, $txt, $scripturl;

    if (!is_array($strip_options)) {
        $strip_options = array();
    }

    // Create the buttons...
    $buttons = array();
    foreach ($button_strip as $key => $value) {
        if (!isset($value['test']) || !empty($context[$value['test']])) {
            $buttons[] = '
				<li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><span>' . $txt[$value['text']] . '</span></a></li>';
        }
    }

    // No buttons? No button strip either.
    if (empty($buttons)) {
        return;
    }

    // Make the last one, as easy as possible.
    $buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

    echo '
		<div class="buttonlist', !empty($direction) ? ' float' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"' : ''), '>
			<ul>',
    implode('', $buttons), '
			</ul>
		</div>';
}

function dt()
{
    global $context, $settings, $txt;
    if (!empty($settings['advert_control'])) {
        echo '
		<div id="upshrinkHeaderIC1">	
			<div class="title_barIC">
				<h4 class="titlebg">
					<span class="ie6_header floatleft">
						<span>', $txt['advert_header'], '</span>
					</span>
				</h4>
			</div>
			<span id="advert">', !empty($settings['advertt']) ? '' . parse_bbc($settings['advertt']) . '' : '', '</span>';
        echo '
		</div>';
    }
}

function dt1()
{
    global $context, $settings, $txt;
    if (!empty($settings['advert_controla'])) {
        echo '
		<div id="upshrinkHeaderIC2">	
			<div class="title_barIC">
				<h4 class="titlebg">
					<span class="ie6_header floatleft">
						<span>', $txt['advert_header'], '</span>
					</span>
				</h4>
			</div>
			<span id="advert1">', !empty($settings['advert1a']) ? '' . parse_bbc($settings['advert1a']) . '' : '', '</span>';
        echo '
		</div><br />';
    }
}

?>

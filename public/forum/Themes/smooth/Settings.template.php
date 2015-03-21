<?php
// Version: 2.0.2; Settings

function template_options()
{
	global $context, $settings, $options, $scripturl, $txt;

	$context['theme_options'] = array(
		array(
			'id' => 'show_board_desc',
			'label' => $txt['board_desc_inside'],
			'default' => true,
		),
		array(
			'id' => 'show_children',
			'label' => $txt['show_children'],
			'default' => true,
		),
		array(
			'id' => 'use_sidebar_menu',
			'label' => $txt['use_sidebar_menu'],
			'default' => true,
		),
		array(
			'id' => 'show_no_censored',
			'label' => $txt['show_no_censored'],
			'default' => true,
		),
		array(
			'id' => 'return_to_post',
			'label' => $txt['return_to_post'],
			'default' => true,
		),
		array(
			'id' => 'no_new_reply_warning',
			'label' => $txt['no_new_reply_warning'],
			'default' => true,
		),
		array(
			'id' => 'view_newest_first',
			'label' => $txt['recent_posts_at_top'],
			'default' => true,
		),
		array(
			'id' => 'view_newest_pm_first',
			'label' => $txt['recent_pms_at_top'],
			'default' => true,
		),
		array(
			'id' => 'posts_apply_ignore_list',
			'label' => $txt['posts_apply_ignore_list'],
			'default' => false,
		),
		array(
			'id' => 'wysiwyg_default',
			'label' => $txt['wysiwyg_default'],
			'default' => false,
		),
		array(
			'id' => 'popup_messages',
			'label' => $txt['popup_messages'],
			'default' => true,
		),
		array(
			'id' => 'copy_to_outbox',
			'label' => $txt['copy_to_outbox'],
			'default' => true,
		),
		array(
			'id' => 'pm_remove_inbox_label',
			'label' => $txt['pm_remove_inbox_label'],
			'default' => true,
		),
		array(
			'id' => 'auto_notify',
			'label' => $txt['auto_notify'],
			'default' => true,
		),
		array(
			'id' => 'topics_per_page',
			'label' => $txt['topics_per_page'],
			'options' => array(
				0 => $txt['per_page_default'],
				5 => 5,
				10 => 10,
				25 => 25,
				50 => 50,
			),
			'default' => true,
		),
		array(
			'id' => 'messages_per_page',
			'label' => $txt['messages_per_page'],
			'options' => array(
				0 => $txt['per_page_default'],
				5 => 5,
				10 => 10,
				25 => 25,
				50 => 50,
			),
			'default' => true,
		),
		array(
			'id' => 'calendar_start_day',
			'label' => $txt['calendar_start_day'],
			'options' => array(
				0 => $txt['days'][0],
				1 => $txt['days'][1],
				6 => $txt['days'][6],
			),
			'default' => true,
		),
		array(
			'id' => 'display_quick_mod',
			'label' => $txt['display_quick_mod'],
			'options' => array(
				0 => $txt['display_quick_mod_none'],
				1 => $txt['display_quick_mod_check'],
				2 => $txt['display_quick_mod_image'],
			),
			'default' => true,
		),
	);
}

function template_settings()
{
	global $context, $settings, $options, $scripturl, $txt;

	$context['theme_settings'] = array(
		array(
			'id' => 'forum_width',
			'label' => $txt['forum_width'],
			'description' => $txt['forum_width_desc'],
			'type' => 'text',
			'size' => 8,
		),
		'',
		array(
			'id' => 'on_image',
			'label' => $txt['on_image'],
			'type' => 'text',
			'size' => 80,
		),
		array(
			'id' => 'on2_image',
			'label' => $txt['on2_image'],
			'type' => 'text',
			'size' => 80,
		),
		array(
			'id' => 'off_image',
			'label' => $txt['off_image'],
			'type' => 'text',
			'size' => 80,
		),
		array(
			'id' => 'redirect_image',
			'label' => $txt['redirect_image'],
			'type' => 'text',
			'size' => 80,
		),
		array(
			'id' => 'new_some_image',
			'label' => $txt['new_some_image'],
			'type' => 'text',
			'size' => 80,
		),
		array(
			'id' => 'new_none_image',
			'label' => $txt['new_none_image'],
			'type' => 'text',
			'size' => 80,
		),
		array(
			'id' => 'new_redirect_image',
			'label' => $txt['new_redirect_image'],
			'type' => 'text',
			'size' => 80,
		),
		'',
		array(
			'id' => 'advert_control',
			'label' => $txt['advert_control'],
			'description' => $txt['advert_control_desc'],
		),
		array(
			'id' => 'advertt',
			'label' => $txt['advert'],
			'description' => $txt['advert_desc'],
			'type' => 'text',
		),
		array(
			'id' => 'advert_controla',
			'label' => $txt['advert_controla'],
			'description' => $txt['advert_control_desca'],
		),
		array(
			'id' => 'advert1a',
			'label' => $txt['adverta'],
			'description' => $txt['advert_desca'],
			'type' => 'text',
		),
		'',
		array(
			'id' => 't_terms',
			'label' => $txt['t_terms_admin'],
			'description' => '',
			'type' => 'text',
		),
		array(
			'id' => 't_policy',
			'label' => $txt['t_policy_admin'],
			'description' => '',
			'type' => 'text',
		),
		array(
			'id' => 't_contact',
			'label' => $txt['t_contact_admin'],
			'description' => '',
			'type' => 'text',
		),
		array(
			'id' => 'cc_control',
			'label' => $txt['cc_control'],
			'description' => $txt['cc_control_desc'],
		),
		array(
			'id' => 'cc',
			'label' => $txt['cc'],
			'description' => $txt['cc_desc'],
			'type' => 'text',
		),
	'',
		array(
			'id' => 'smiley_sets_default',
			'label' => $txt['smileys_default_set_for_theme'],
			'options' => $context['smiley_sets'],
			'type' => 'text',
		),
		array(
			'id' => 'linktree_link',
			'label' => $txt['current_pos_text_img'],
		),
		array(
			'id' => 'show_mark_read',
			'label' => $txt['enable_mark_as_read'],
		),
		array(
			'id' => 'allow_no_censored',
			'label' => $txt['allow_no_censored'],
		),
		array(
			'id' => 'enable_news',
			'label' => $txt['enable_random_news'],
		),
	'',
		array(
			'id' => 'show_newsfader',
			'label' => $txt['news_fader'],
		),
		array(
			'id' => 'newsfader_time',
			'label' => $txt['admin_fader_delay'],
			'type' => 'number',
		),
		array(
			'id' => 'number_recent_posts',
			'label' => $txt['number_recent_posts'],
			'description' => $txt['number_recent_posts_desc'],
			'type' => 'number',
		),
		array(
			'id' => 'show_stats_index',
			'label' => $txt['show_stats_index'],
		),
		array(
			'id' => 'show_latest_member',
			'label' => $txt['latest_members'],
		),
		array(
			'id' => 'show_group_key',
			'label' => $txt['show_group_key'],
		),
	'',
		array(
			'id' => 'show_modify',
			'label' => $txt['last_modification'],
		),
	'',
		array(
			'id' => 'show_bbc',
			'label' => $txt['admin_bbc'],
		),
		array(
			'id' => 'additional_options_collapsable',
			'label' => $txt['additional_options_collapsable'],
		),
	);
}

?>
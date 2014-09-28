<?php

if (!defined('SMF'))
	die('Hacking attempt...');

// The template for Moderator Board Managment ;).
function template_tapatalk_show_boards()
{
	global $context, $settings, $options, $scripturl, $txt;
	
	//Some Javascript things ;)
	echo '
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		function selectBoards(ids)
		{
			var toggle = true;

			for (i = 0; i < ids.length; i++)
				toggle = toggle & document.forms.creator["brd" + ids[i]].checked;

			for (i = 0; i < ids.length; i++)
				document.forms.creator["brd" + ids[i]].checked = !toggle;
		}
	// ]]></script>';

	echo '
	<div id="admincenter">
	<form name="creator" action="', $context['post_url'], '" method="post" accept-charset="', $context['character_set'], '"', !empty($context['force_form_onsubmit']) ? ' onsubmit="' . $context['force_form_onsubmit'] . '"' : '', '>
		
			
					<table border="0" cellspacing="0" cellpadding="4" width="100%">';

	// Is there a custom title?
	if (isset($context['settings_title']))
		echo '
		<div class="cat_bar">
<h3 class="catbg"> Tapatalk Settings </h3>
		</div>';

	//Hide boards option
	echo '	
						<tr>
							<td class="windowbg2" colspan="3">
								<fieldset class="windowbg2" style="padding: 10px; margin-left: 5px; margin-right: 5px;">
								<a id="" class="help" onclick="return reqWin(this.href);" href="index.php?action=helpadmin;help=tp_hide_boards">
<img align="right" class="icon" alt="Help" src="Themes/default/images/helptopics.gif">
</a>
										<strong>' . $txt['tp_select_boards'] . '</strong><br />
										<table id="searchBoardsExpand" width="100%" border="0" cellpadding="1" cellspacing="0" align="center" style="margin-top: 1ex;">';

			$alternate = true;
			foreach ($context['board_columns'] as $board)
			{
				if ($alternate)
					echo '
											<tr>';
				echo '
												<td width="50%">';

				if (!empty($board) && empty($board['child_ids']))
					echo '
													<label for="brd', $board['id'], '" style="margin-left: ', $board['child_level'], 'ex;"><input type="checkbox" id="brd', $board['id'], '" name="brd[', $board['id'], ']" value="', $board['id'], '"', $board['is_moderator'] ? ' checked="checked"' : '', ' class="check" />', $board['name'], '</label>';
				elseif (!empty($board))
					echo '
													<a href="javascript:void(0);" onclick="selectBoards([', implode(', ', $board['child_ids']), ']); return false;" style="text-decoration: underline;">', $board['name'], '</a>';

				echo '
												</td>';
				if (!$alternate)
					echo '
											</tr>';

				$alternate = !$alternate;
			}

			echo '
										</table><br />
										<input type="checkbox" name="all" id="check_all" value=""'.($context['all_checked'] ? ' checked="checked"' : '').' onclick="invertAll(this, this.form, \'brd\');" class="check" /><i> <label for="check_all">', $txt['check_all'], '</label></i><br />
									</fieldset> 
								</td>
							</tr>';
//disable new topic option
	echo '	
						<tr>
							<td class="windowbg2" colspan="3">
								<fieldset class="windowbg2" style="padding: 10px; margin-left: 5px; margin-right: 5px;">
<a id="" class="help" onclick="return reqWin(this.href);" href="index.php?action=helpadmin;help=tp_dsa_boards">
<img align="right" class="icon" alt="Help" src="Themes/default/images/helptopics.gif">
</a>
										<strong>' . $txt['tp_disable_newtopic'] . '</strong><br />
										<table id="searchBoardsExpand" width="100%" border="0" cellpadding="1" cellspacing="0" align="center" style="margin-top: 1ex;">';

			$alternate = true;
			foreach ($context['board_columns'] as $board)
			{
				if ($alternate)
					echo '
											<tr>';
				echo '
												<td width="50%">';

				if (!empty($board) && empty($board['child_ids']))
					echo '
													<label for="dsa_brd', $board['id'], '" style="margin-left: ', $board['child_level'], 'ex;"><input type="checkbox" id="dsa_brd', $board['id'], '" name="dsa_brd[', $board['id'], ']" value="', $board['id'], '"', $board['is_disabled_new_tp'] ? ' checked="checked"' : '', ' class="check" />', $board['name'], '</label>';
				elseif (!empty($board))
					echo '
													<a href="javascript:void(0);" onclick="selectBoards([', implode(', ', $board['child_ids']), ']); return false;" style="text-decoration: underline;">', $board['name'], '</a>';

				echo '
												</td>';
				if (!$alternate)
					echo '
											</tr>';

				$alternate = !$alternate;
			}

			echo '
										</table><br />
										<input type="checkbox" name="dsa_all" id="check_all" value=""'.(isset($context['dsa_all_checked']) && $context['dsa_all_checked'] ? ' checked="checked"' : '').' onclick="invertAll(this, this.form, \'dsa_brd\');" class="check" /><i> <label for="dsa_check_all">', $txt['check_all'], '</label></i><br />
									</fieldset> 
								</td>
							</tr>';
			echo '
			
						<tr>
						
							<td class="windowbg2" colspan="3" align="right" valign="right">
							<input  class="button_submit" type="submit" value="', $txt['save'], '"', (!empty($context['save_disabled']) ? ' disabled="disabled"' : ''), ' /></td>
						</tr>';

	echo '
					</table>
				
		<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
	</form></div>';
}
?>
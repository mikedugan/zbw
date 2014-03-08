<?php
namespace Zbw;

class Helpers {
	static function isStaff($user)
	{
		return $user->is_atm || $user->is_datm || $user->is_ta || $user->is_webmaster || $user->is_facilities ||
		$user->is_instructor || $user->is_mentor;
	}
}
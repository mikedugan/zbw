<?php
namespace Zbw;

use Carbon\Carbon;

class Helpers {
	static function isStaff($user)
	{
		return $user->is_atm || $user->is_datm || $user->is_ta || $user->is_webmaster || $user->is_facilities ||
		$user->is_instructor || $user->is_mentor;
	}

    public static function timeAgo($date)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        return $date->diffForHumans();
    }

    public static function getWrongCount($exam)
    {
        return count(explode(',', $exam->wrong_questions)) - 1;
    }
}

<?php
namespace Zbw;

use Carbon\Carbon;

class Helpers {
    /**
     * @summary deprecated, is user a staff member?
     * @deprecated
     * @param \User $user
     * @return boolean
     */
    static function isStaff($user)
	{
		return $user->is_atm || $user->is_datm || $user->is_ta || $user->is_webmaster || $user->is_facilities ||
		$user->is_instructor || $user->is_mentor;
	}

    /**
     * @summary given a date string, returns the relative time difference
     * @param string $date
     * @return \Carbon DateTime difference
     */
    public static function timeAgo($date)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        return $date->diffForHumans();
    }

    /**
     * @summary returns the total number of wrong questions
     * @param \ControllerExam $exam
     * @return integer
     */
    public static function getScore($exam)
    {
        return (count(explode(',', $exam->wrong_questions)) - 1) / $exam->total_questions * 100;
    }

    /**
     * @summary Returns an array or CSV list of CIDs
     * @param boolean $csv
     * @return array
     */
    public static function getCids($csv = false)
    {
        return $csv ? implode(',', array_values(\DB::table('controllers')->lists('cid'))) : array_values(\DB::table('controllers')->lists('cid'));
    }

    public static function getSids($csv = false)
    {
        return $csv ? implode(',', array_values(\DB::table('controllers')->where('is_staff', '=', 1)->pluck('cid'))) :
                        array_values(\DB::table('controllers')->where('is_staff', '=', 1)->pluck('cid'));
    }

    public static function getTids($csv = false)
    {
        return $csv ? implode(',', array_values(\DB::table('controllers')->where('is_mentor', '=', 1)->orWhere('is_instructor', '=', 1)->pluck('cid')))
                    : array_values(\DB::table('controllers')->where('is_mentor', '=', 1)->orWhere('is_instructor', '=', 1)->pluck('cid'));
    }

    public static function readableCert($cert)
    {
        switch($cert)
        {   case 'C_S1': return "Class C/D Ground"; break;
            case 'B_S1': return "Class B Ground"; break;
            case 'C_S2': return "Class C/D Tower"; break;
            case 'B_S2': return "Class B Tower"; break;
            case 'C_S3': return "Class C Approach"; break;
            case 'B_S3': return "Class B Approach"; break;
            case 'C_C1': return "Off Peak Center"; break;
            case 'B_C1': return "Center Controller"; break;
        }
    }

    public static function createPassword($len = 8)
    {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function convertToCarbon($date)
    {
        return \Carbon::createFromFormat('Y-m-d H:i:s', $date);
    }
}

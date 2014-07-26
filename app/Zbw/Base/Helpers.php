<?php
namespace Zbw\Base;

use Carbon\Carbon;

class Helpers
{

    /**
     * @summary given a date string, returns the relative time difference
     *
     * @param string $date
     *
     * @return \Carbon DateTime difference
     */
    public static function timeAgo($date)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        return $date->diffForHumans();
    }

    /**
     * @summary returns the total number of wrong questions
     *
     * @param \ControllerExam $exam
     *
     * @return integer
     */
    public static function getScore($exam)
    {
        return (count(
            explode(',', $exam->wrong_questions)
          ) - 1) / $exam->total_questions * 100;
    }

    /**
     * @summary Returns an array or CSV list of CIDs
     *
     * @param boolean $csv
     *
     * @return array
     */
    public static function getCids($csv = false)
    {
        return $csv ? implode(
          ',',
          array_values(\DB::table('users')->lists('cid'))
        ) : array_values(\DB::table('users')->lists('cid'));
    }

    public static function getSids($csv = false)
    {
        return $csv ? implode(
          ',',
          array_values(
            \DB::table('users')->where('is_staff', '=', 1)->pluck('cid')
          )
        ) :
          array_values(
            \DB::table('users')->where('is_staff', '=', 1)->pluck('cid')
          );
    }

    public static function getTids($csv = false)
    {
        return $csv ? implode(
          ',',
          array_values(
            \DB::table('users')->where('is_mentor', '=', 1)->orWhere(
              'is_instructor',
              '=',
              1
            )->pluck('cid')
          )
        )
          : array_values(
            \DB::table('users')->where('is_mentor', '=', 1)->orWhere(
              'is_instructor',
              '=',
              1
            )->pluck('cid')
          );
    }

    /**
     * @type static
     * @name  readableRating
     * @deprecated
     * @description returns a readable rating string
     * @deprecated left to prevent breakage
     * @param $rating
     * @return string
     */
    public static function readableRating($rating)
    {
        switch($rating) {
            case 'O':
                return 'Observer';
            break;
            case 'S1':
                return 'Tower Trainee';
            break;
            case 'S2':
                return 'Tower Controller';
            break;
            case 'S3':
                return 'TMA Controller';
            break;
            case 'C1':
                return 'Enroute Controller';
            break;
            case 'C3':
                return 'Senior Controller';
            break;
            case 'I1':
                return 'Instructor';
            break;
            case 'I3':
                return 'Senior Instructor';
            default:
                return 'Controller';
            break;
        }
    }

    /**
     * @type static
     * @name  readableCert
     * @description returns a readable ZBW cert string
     * @param $cert
     * @return string
     */
    public static function readableCert($cert)
    {
        switch ($cert) {
            case '1':
                return 'Observer';
                break;
            case '2':
                return "Class C/D Ground";
                break;
            case '3':
                return "Class B Ground (Off Peak)";
                break;
            case '4':
                return "Class B Ground";
                break;
            case '5':
                return "Class C/D Tower";
                break;
            case '6':
                return "Class B Tower (Off Peak)";
                break;
            case '7':
                return "Class B Tower";
                break;
            case '8':
                return "Class C Approach";
                break;
            case '9':
                return "Class B Approach (Off Peak)";
                break;
            case '10':
                return "Class B Approach";
                break;
            case '11':
                return "Center (Off Peak)";
                break;
            case '12':
                return "Center Controller";
                break;
            case '13':
                return 'Instructor';
                break;
            case '14':
                return 'Senior Instructor';
                break;
            case '15':
                return 'Senior Controller';
                break;
        }
    }

    public static function staffStatusString($controller, $delim = ', ')
    {
        $status = [];
        if($controller->is_atm) $status[0] = 'ATM';
        else if($controller->is_datm) $status[0] = 'DATM';
        else if($controller->is_ta) $status[0] = 'TA';
        else if($controller->is_webmaster) $status[0] = 'Webmaster';
        else if($controller->is_fe) $status[0] = 'Facilities Engineer';
        if($controller->is_instructor) $status[1] = 'Instructor';
        if($controller->is_mentor) $status[1] = 'Mentor';
        return implode($delim, $status);
    }

    /**
     * @deprecated
     * use vatsim auth instead
     */
    public static function createPassword($len = 8)
    {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an arrayfun
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * @deprecated
     * instead use getDates on models
     */
    public static function convertToCarbon($date)
    {
        return \Carbon::createFromFormat('m-d-Y H:i:s', $date);
    }

    public static function makeLines($text, $r = true)
    {
        if ($r)
            $text = explode("\r\n", trim($text));
        else {
            $text = explode("\n", trim($text));
        }
        return array_filter($text, 'trim');
    }
}

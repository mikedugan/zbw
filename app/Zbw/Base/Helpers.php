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

    public static function letterToDigit($input)
    {
        switch($input) {
            case 'a': return 1; break;
            case 'b': return 2; break;
            case 'c': return 3; break;
            case 'd': return 4; break;
            case 'e': return 5; break;
            case 'f': return 6; break;
        }
    }

    public static function digitToLetter($input)
    {
        switch($input) {
            case 1: return 'a'; break;
            case 2: return 'b'; break;
            case 3: return 'c'; break;
            case 4: return 'd'; break;
            case 5: return 'e'; break;
            case 6: return 'f'; break;
        }
    }

    public static function staffStatusString($controller, $delim = ', ')
    {
        $status = [];
        if($controller->is_atm) $status[0] = 'ATM';
        else if($controller->is('DATM')) $status[0] = 'DATM';
        else if($controller->is('TA')) $status[0] = 'TA';
        else if($controller->is('WEB')) $status[0] = 'Webmaster';
        else if($controller->is('FE')) $status[0] = 'Facilities Engineer';
        else if($controller->is('Events')) $status[0] = 'Events Coordinator';
        if($controller->is('Instructors')) $status[1] = 'Instructor';
        if($controller->is('Mentors')) $status[1] = 'Mentor';
        return implode($delim, $status);
    }

    /**
     * @deprecated
     * use vatsim auth instead
     */
    public static function createPassword($len = 8)
    {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = []; //remember to declare $pass as an arrayfun
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

    /**
     * @type static
     * @description helper function to nom a route down to the first 3 and last 3 fixes
     *
     * @param $route string
     *
     * @return string
     */
    public static function shortenRouteString($route)
    {
        $strings = explode(' ', $route);
        if(count($strings) > 12) {
            $start = array_slice($strings, 0, 3);
            $start[] = '...';
            $end = array_slice($strings, -3, 3);
            $route = array_merge($start, $end);
            return implode(' ', $route);
        }
        else return $route;
    }

    public static function pilotFeedbackRating($rating)
    {
        switch($rating) {
            case 0:
                return 'Eek';
            break;
            case 1:
                return 'Poor';
            break;
            case 2:
                return 'Fair';
            break;
            case 3:
                return 'Average';
            break;
            case 4:
                return 'Good';
            break;
            case 5:
                return 'Excellent';
            break;
            case 6:
                return 'Whoa';
            break;
        }
    }
}

<?php
namespace Zbw\Base;

use Carbon\Carbon;

/**
 * @package Base
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class Helpers
{

    /**
     * given a date string, returns the relative time difference
     *
     * @param string|\Carbon $date
     * @return string
     */
    public static function timeAgo($date)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        return $date->diffForHumans();
    }

    /**
     * returns the total number of wrong questions
     *
     * @param \ControllerExam $exam
     * @return double
     */
    public static function getScore($exam)
    {
        return round( $exam->correct / $exam->total_questions * 100, 2);
    }

    /**
     * Returns an array or CSV list of CIDs
     * @static
     * @param boolean $csv
     * @return array
     * @deprecated 2.0.9b - use lists on the UserRepository
     */
    public static function getCids($csv = false)
    {
        return $csv ? implode(
          ',',
          array_values(\DB::table('users')->lists('cid'))
        ) : array_values(\DB::table('users')->lists('cid'));
    }

    /**
     * deprecated - do not use
     *
     * @static
     * @param bool $csv
     * @return array|string
     * @deprecated 2.0.9b   use lists on the UserRepository
     */
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

    /**
     * @static
     * @param bool $csv
     * @return array|string
     * @deprecated 2.0.9b   use lists on the UserRepository
     */
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
     * @static
     * @deprecated 2.0.7b   left to prevent breakage
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
     * Returns a user-readable rendition of a cert
     *
     * @static
     * @param $cert
     * @return string
     */
    public static function readableCert($cert)
    {
        switch ($cert) {
            case '0':
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

    /**
     * @static
     * @param $input
     * @return int
     */
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

    /**
     * @static
     * @param $input
     * @return string
     */
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

    /**
     * Creates a readable string of a \User staff status
     *
     * @static
     * @param \User $controller
     * @param string $delim
     * @return string
     */
    public static function staffStatusString($controller, $delim = ', ')
    {
        $status = [];
        if($controller->is('ATM')) $status[0] = 'ATM';
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
     * @static
     * @param $text
     * @param bool $r
     * @return array
     */
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
     *  Cuts a route down to the first 3 and last 3 fixes
     *
     * @static
     * @param $route string
     * @return string
     */
    public static function shortenRouteString($route)
    {
        $strings = explode(' ', $route);
        if(count($strings) > 9 || strlen($route) > 24) {
            $start = array_slice($strings, 0, 3);
            $start[] = '...';
            $end = array_slice($strings, -3, 3);
            $route = array_merge($start, $end);
            return implode(' ', $route);
        }
        else return $route;
    }

    /**
     * Converts feedback int to a string rating
     *
     * @static
     * @param integer $rating
     * @return string
     */
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

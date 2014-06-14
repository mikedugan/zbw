<?php
namespace Zbw;

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
          array_values(\DB::table('controllers')->lists('cid'))
        ) : array_values(\DB::table('controllers')->lists('cid'));
    }

    public static function getSids($csv = false)
    {
        return $csv ? implode(
          ',',
          array_values(
            \DB::table('controllers')->where('is_staff', '=', 1)->pluck('cid')
          )
        ) :
          array_values(
            \DB::table('controllers')->where('is_staff', '=', 1)->pluck('cid')
          );
    }

    public static function getTids($csv = false)
    {
        return $csv ? implode(
          ',',
          array_values(
            \DB::table('controllers')->where('is_mentor', '=', 1)->orWhere(
              'is_instructor',
              '=',
              1
            )->pluck('cid')
          )
        )
          : array_values(
            \DB::table('controllers')->where('is_mentor', '=', 1)->orWhere(
              'is_instructor',
              '=',
              1
            )->pluck('cid')
          );
    }

    /**
     * @type static
     * @name  readableRating
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
            case 'C_S1':
                return "Class C/D Ground";
                break;
            case 'B_S1':
                return "Class B Ground";
                break;
            case 'C_S2':
                return "Class C/D Tower";
                break;
            case 'B_S2':
                return "Class B Tower";
                break;
            case 'C_S3':
                return "Class C Approach";
                break;
            case 'B_S3':
                return "Class B Approach";
                break;
            case 'C_C1':
                return "Off Peak Center";
                break;
            case 'B_C1':
                return "Center Controller";
                break;
        }
    }

    /**
     * @deprecated
     * use vatsim auth instead
     */
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

    /**
     * @deprecated
     * instead use getDates on models
     */
    public static function convertToCarbon($date)
    {
        return \Carbon::createFromFormat('Y-m-d H:i:s', $date);
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

<?php

/**
 * VisitorApplicant
 *
 * @property integer $id
 * @property integer $cid
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property integer $rating
 * @property string $division
 * @property string $home
 * @property string $message
 * @property string $comments
 * @property boolean $accepted
 * @property \Carbon\Carbon $accepted_on
 * @property boolean $lor_submitted
 * @property \Carbon\Carbon $lor_submitted_on
 * @property string $lor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereCid($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereEmail($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereFirstName($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereLastName($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereRating($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereDivision($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereHome($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereMessage($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereComments($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereAccepted($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereAcceptedOn($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereLorSubmitted($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereLorSubmittedOn($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereLor($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\VisitorApplicant whereUpdatedAt($value) 
 */
class VisitorApplicant extends BaseModel
{
    public $table = 'visitor_applicants';
    static $rules = [
        'cid' => 'integer|cid',
        'email' => 'email|required',
        'first_name' => 'max:40',
        'last_name' => 'max:40',
        'rating' => 'integer|max:20',
        'division' => 'max:30',
        'home' => 'max:10'
    ];

    protected $guarded = [
        'accepted, accepted_on'
    ];

    public function getDates()
    {
        return ['created_at', 'updated_at', 'accepted_on', 'lor_submitted_on'];
    }

} 

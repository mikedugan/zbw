<?php  namespace Zbw\Users\Commands; 

class SearchUsersCommand
{
    public $cid;
    public $email;
    public $rating;
    public $fname;
    public $lname;
    public $oi;

    function __construct($input)
    {
        $this->cid = $input['cid'];
        $this->email = isset($input['email']) ? $input['email'] : null;
        $this->rating = $input['rating'];
        $this->fname = $input['fname'];
        $this->lname = $input['lname'];
        $this->oi = $input['oi'];
    }
}

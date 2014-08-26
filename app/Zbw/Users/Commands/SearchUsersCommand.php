<?php  namespace Zbw\Users\Commands; 

class SearchUsersCommand
{
    public $cid;
    public $email;
    public $rating;
    public $fname;
    public $lname;

    function __construct($input)
    {
        $this->cid = $input['cid'];
        $this->email = $input['email'];
        $this->rating = $input['rating'];
        $this->fname = $input['fname'];
        $this->lname = $input['lname'];
    }
}

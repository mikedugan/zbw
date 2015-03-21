<?php namespace Zbw\Users\Commands;

class AcceptVisitorCommand
{
    public $cid;
    public $sid;

    public function __construct($cid, $sid)
    {
        $this->cid = $cid;
        $this->sid = $sid;
    }
}

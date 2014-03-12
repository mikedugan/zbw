<?php namespace Zbw\Composites;

class ZbwController {
    protected $user;
    public $certs;

    public function __construct(\User $user = null)
    {
        $this->user = $user ? $user : null;
        $this->certs = ControllerCert::where('cid', '=', $this->user->cid)->with(['type'])->get();

    }
}

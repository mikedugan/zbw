<?php namespace Zbw\Http\Controllers;

use Zbw\Users\Commands\AcceptVisitorCommand;
use Illuminate\Session\Store;
use Zbw\Users\Contracts\VisitorApplicantRepositoryInterface;
use Zbw\Http\Controllers\BaseController;

class VisitorController extends BaseController
{
    private $visitors;

    public function __construct(VisitorApplicantRepositoryInterface $visitors, Store $session)
    {
        parent::__construct($session);
        $this->visitors = $visitors;
    }

    /**
     * @param $id
     * @return string
     */
    public function postVisitorAccept($id)
    {
        $response = $this->execute(AcceptVisitorCommand::class, ['cid' => $id, 'sid' => $this->current_user->cid]);
        if($response === true) {
            return $this->json(['success' => true,'message' => 'Visitor application accepted.']);
        } else {
            return $this->json(['success' => false,'message' => implode(',', $this->visitors->getErrors())]);
        }
    }
}

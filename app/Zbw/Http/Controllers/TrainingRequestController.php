<?php namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use Zbw\Training\Contracts\TrainingRequestRepositoryInterface;

class TrainingRequestController extends \Zbw\Http\Controllers\BaseController
{
    private $requests;

    public function __construct(TrainingRequestRepositoryInterface $requests, Store $session)
    {
        parent::__construct($session);
        $this->requests = $requests;
    }

    /**
     * @return string
     */
    public function postTrainingRequest()
    {
        try {
            if($this->requests->create(\Input::all())) {
                return $this->json(['success' => true,'message' => 'Training request added successfully']);
            } else {
                return $this->json(['success'  => false,'messaage' => 'Error sending training request!']);
            }
        } catch(InvalidArgumentException $e) {
            return $this->json(['success' => false,'message' => \Input::get('start')]);
        }
    }

    /**
     * @param $tsid
     * @throws Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelTrainingRequest($tsid)
    {
        if ($this->requests->delete($tsid)) {
            return \Redirect::home()->with('flash_success', 'Training session cancelled');
        } else {
            return \Redirect::back()->with('flash_error', 'Unable to cancel session');
        }
    }

    /**
     * @param $tsid
     * @return string
     */
    public function acceptTrainingRequest($tsid)
    {
        if ($this->requests->accept($tsid, $this->current_user->cid, \Input::all())) {
            return $this->json(['success' => true,'message' => 'Training session accepted. Page reload in 2 seconds...']);
        } else {
            return $this->json(['success' => false,'message' => 'Error accepting training session.']);
        }
    }

    /**
     * @param $tid
     * @return string
     */
    public function dropTrainingRequest($tid)
    {
        if ($this->requests->drop($tid, \Sentry::getUser()->cid)) {
            return $this->json(['success' => true,'message' => 'Training session dropped.']);
        } else {
            return $this->json(['success' => false,'message' => 'Unable to drop training session']);
        }
    }
}

<?php namespace Zbw\Http\Controllers;

use Illuminate\Session\Store;
use Zbw\Users\Contracts\StaffingRepositoryInterface;

class StaffingController extends BaseController
{
    private $staffings;

    public function __construct(StaffingRepositoryInterface $staffings, Store $session)
    {
        parent::__construct($session);
        $this->staffings = $staffings;
    }

    public function getIndex()
    {
        $this->setData('staffings', $this->staffings->paginateAll(40));
        return $this->view('staff.staffing');
    }
}

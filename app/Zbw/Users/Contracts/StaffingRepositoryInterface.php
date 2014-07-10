<?php namespace Zbw\Users\Contracts;

interface StaffingRepositoryInterface
{
    public function recent($n = 5);

    public function position($pos);

    public function getControllerStaffings($cid);
}

<?php namespace Zbw\Training\Contracts;

interface StaffAvailabilityRepositoryInterface
{
    public function create($input);

    /**
     * @param $input
     * @return mixed
     */
    public function update($input);
}

<?php namespace Zbw\Users\Contracts;

interface ScheduleRepositoryInterface
{
    public function today();

    public function upcoming($n = 5);

    /**
     * @param $input
     * @return mixed
     */
    public function update($input);
}

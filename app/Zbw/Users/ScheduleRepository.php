<?php namespace Zbw\Users; 

use Zbw\Core\EloquentRepository;
use Zbw\Users\Contracts\ScheduleRepositoryInterface;

class ScheduleRepository extends EloquentRepository implements ScheduleRepositoryInterface
{
    public $model = '\Schedule';

    public function today()
    {
        return $this->make()->where('start', '<', \Carbon::tomorrow())->where('start','>',\Carbon::now());
    }

    public function upcoming($n = 5)
    {
        return $this->make()->with('controller')->where('start','>',\Carbon::now())->orderBy('start', 'DESC')->limit($n)->get();
    }

    public function create($input)
    {
        $schedule = $this->make();
        $schedule->cid = $input['cid'];
        $schedule->position = $input['position'];
        $schedule->start = \Carbon::createFromFormat('m-d-Y H:i:s', $input['start']);
        $schedule->end = \Carbon::createFromFormat('m-d-Y H:i:s', $input['end']);
        return $schedule->save();
    }

    /**
     * @param $input
     * @return mixed
     */
    public function update($input)
    {
    }
}

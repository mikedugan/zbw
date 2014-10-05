<?php namespace Zbw\Training; 

use Zbw\Core\EloquentRepository;
use Zbw\Training\Contracts\StaffAvailabilityRepositoryInterface;

class StaffAvailabilityRepository extends EloquentRepository implements StaffAvailabilityRepositoryInterface
{
    public $model = '\StaffAvailability';

    public function create($input)
    {
        $input['start'] = \Carbon::createFromFormat('m-d-Y H:i:s', $input['start']);
        $input['end'] = \Carbon::createFromFormat('m-d-Y H:i:s', $input['end']);
        $avail = $this->make($input);
        return $avail->save();
    }

    public function upcoming($n = 10)
    {
        return $this->make()->where('start','>', \Carbon::now())->orderBy('start', 'ASC')->limit($n)->get();
    }

    /**
     * @param $input
     * @return mixed
     */
    public function update($input)
    {
    }
}

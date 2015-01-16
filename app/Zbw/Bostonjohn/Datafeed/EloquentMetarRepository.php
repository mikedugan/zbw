<?php namespace Zbw\Bostonjohn\Datafeed;

use Zbw\Core\EloquentRepository;

class EloquentMetarRepository extends EloquentRepository
{
    public $model = \Metar::class;

    public function getStaleMetars()
    {
        return $this->make()->where('created_at', '<', \Carbon::now()->subMinutes(120))->lists('id');
    }

    public function delete($ids)
    {
        return $this->make()->destroy($ids);
    }


    /**
     *
     * @param $input
     * @return mixed
     */
    public function update($input)
    {

    }
}

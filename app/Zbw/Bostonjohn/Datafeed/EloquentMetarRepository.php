<?php namespace Zbw\Bostonjohn\Datafeed;

use Zbw\Core\EloquentRepository;

class EloquentMetarRepository extends EloquentRepository
{
    public $model = \Metar::class;

    /**
     * @return int[]
     */
    public function getStaleMetars()
    {
        return $this->make()->where('created_at', '<', \Carbon::now()->subMinutes(120))->lists('id');
    }

    /**
     * @param $ids
     * @return int
     */
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
        throw new \BadMethodCallException("Cannot update METARs", 500);
    }
}

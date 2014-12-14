<?php namespace Zbw\Airports;

use Zbw\Airports\Contracts\AirportRepository;
use Zbw\Core\EloquentRepository;

class EloquentAirportRepository extends EloquentRepository implements AirportRepository
{
    public $model = Airport::class;

    public function getByIcao($icao)
    {
        return $this->make()->whereIcao($icao)->first();
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

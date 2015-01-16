<?php namespace Zbw\Airports;

use Zbw\Airports\Contracts\AirportRepository;
use Zbw\Core\EloquentRepository;

class EloquentAirportRepository extends EloquentRepository implements AirportRepository
{
    public $model = Airport::class;

    /**
     * @param $icao
     * @return Airport
     */
    public function getByIcao($icao)
    {
        return $this->make()->whereIcao($icao)->first();
    }

    /**
     * @param $input
     * @return void
     */
    public function update($input)
    {
        throw new \BadMethodCallException("Method not supported", 500);
    }

    /**
     * @return Airport[]
     */
    public function allByAirspace()
    {
        $airports = $this->make()->orderBy('airspace', 'ASC')->with('frequencies')->get();
        //move the empty airspaces to the end
        while($airports->first()->airspace === '') {
            $airports->push($airports->shift());
        }

        return $airports;
    }

    /**
     * @return Airport[]
     */
    public function allByTracon()
    {
        $airports = $this->make()->where('tracon', '!=', 'N/A')->orderBy('tracon', 'ASC')->get();
        $nas = $this->make()->where('tracon', 'N/A')->get();
        $airports = $airports->merge($nas);
        return $airports;
    }

    /**
     * @return Airport[]
     */
    public function allAlphabetically()
    {
        return $this->make()->orderBy('name', 'ASC')->get();
    }
}

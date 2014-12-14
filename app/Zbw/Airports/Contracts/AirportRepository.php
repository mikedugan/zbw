<?php namespace Zbw\Airports\Contracts;

interface AirportRepository
{
    /**
     * @param $icao
     * @return \Zbw\Airports\Airport
     */
    public function getByIcao($icao);

    /**
     *
     * @param $input
     * @return mixed
     */
    public function update($input);
}

<?php namespace Zbw\Airports\Commands;

use Zbw\Airports\IcaoCode;

class UpdateAirportCommand
{
    public $icao;
    public $data;

    public function __construct($icao, array $data)
    {
        $this->icao = IcaoCode::fromCode($icao);
        $this->data = $data;
    }
}

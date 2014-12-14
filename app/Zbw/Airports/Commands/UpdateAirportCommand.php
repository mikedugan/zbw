<?php namespace Zbw\Airports\Commands;

use Zbw\Airports\IcaoCode;

class UpdateAirportCommand
{
    public $id;
    public $icao;
    public $data;

    public function __construct($id, $icao, array $data)
    {
        $this->id = $id;
        $this->icao = IcaoCode::fromCode($icao);
        $this->data = $data;
    }
}

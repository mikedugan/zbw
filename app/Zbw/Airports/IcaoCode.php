<?php namespace Zbw\Airports;

class IcaoCode
{
    private $icao;

    public function __construct($icao)
    {
        $this->icao = $icao;
    }

    public static function fromCode($icao)
    {
        return new self($icao);
    }

    public function icao()
    {
        return $this->icao;
    }

    public function equals(IcaoCode $icao)
    {
        return $this->icao === $icao->icao();
    }

    public function isValid()
    {
        return preg_match('/^[0-9A-Z]{4}$/', $this->icao);
    }
}

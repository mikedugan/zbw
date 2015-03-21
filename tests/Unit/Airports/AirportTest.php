<?php namespace Tests\Unit\Airports;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Zbw\Airports\Airport;

class AirportTest extends \PHPUnit_Framework_TestCase
{
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $this->resource = new Airport();
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(Airport::class, $this->resource);
    }

    /**
    * @test
    */
    public function airportHasIcaoCode()
    {
        $this->assertInstanceOf(HasMany::class, $this->resource->frequencies());
    }
}

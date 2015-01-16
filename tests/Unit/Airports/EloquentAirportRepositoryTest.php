<?php namespace Tests\Unit\Airports;

use Zbw\Airports\Airport;
use Zbw\Airports\EloquentAirportRepository;

class EloquentAirportRepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $this->resource = new EloquentAirportRepository();
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(EloquentAirportRepository::class, $this->resource);
    }

    /**
    * @test
    */
    public function resourceHasCorrectModel()
    {
        $this->assertEquals(Airport::class, $this->resource->model);
    }
}

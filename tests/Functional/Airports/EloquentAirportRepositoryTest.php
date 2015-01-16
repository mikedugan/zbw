<?php namespace Tests\Functional\Airports;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Zbw\Airports\Airport;
use Zbw\Airports\EloquentAirportRepository;

class EloquentAirportRepositoryTest extends TestCase
{
    /** @var EloquentAirportRepository */
    private $resource;
    public function setUp()
    {
        parent::setUp();
        $this->resource = new EloquentAirportRepository();
    }

    /**
    * @test
    */
    public function retrievesAirportByIcao()
    {
        $airport = $this->resource->getByIcao('KBOS');
        $this->assertInstanceOf(Airport::class, $airport);
        $this->assertEquals('KBOS', $airport->icao);
    }

    /**
    * @test
    */
    public function retrievesAirportsByAirspace()
    {
        $airports = $this->resource->allByAirspace();
        $this->assertInstanceOf(Collection::class, $airports);
        $this->assertInstanceOf(Airport::class, $airports[0]);
    }

    /**
    * @test
    */
    public function retrievesAirportsByTracon()
    {
        $airports = $this->resource->allByTracon();
        $this->assertInstanceOf(Collection::class, $airports);
        $this->assertInstanceOf(Airport::class, $airports[0]);
    }

    /**
    * @test
    */
    public function retrievesAirportsAlphabetically()
    {
        $airports = $this->resource->allAlphabetically();
        $this->assertInstanceOf(Collection::class, $airports);
        $this->assertInstanceOf(Airport::class, $airports[0]);
    }

    /**
    * @test
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method not supported
     * @expectedExceptionCode 500
    */
    public function updateThrowsException()
    {
        $this->resource->update('foo');
    }
}

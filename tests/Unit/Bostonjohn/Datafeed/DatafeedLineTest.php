<?php namespace Tests\Unit\Bostonjohn\Datafeed;

use Zbw\Bostonjohn\Datafeed\DatafeedLine;
use Zbw\Bostonjohn\Datafeed\DatafeedParser;

class DatafeedLineTest extends \PHPUnit_Framework_TestCase
{
    /** @var DatafeedLine */
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $this->resource = new DatafeedLine([11 => 'KBOS', 13 => 'KBOS']);
    }

    private function setFlightLine($zbw = true)
    {
        $zbwLine = [
            4 => '134.700',
            11 => 'KBOS',
            13 => 'KBOS'
        ];
        $line = [
            4 => '134.700',
            11 => 'KJFK',
            13 => 'KJFK'
        ];
        $this->resource = new DatafeedLine($zbw ? $zbwLine : $line);
        $this->checkInstance($this->resource);
    }

    private function setAirportLine($zbw = true)
    {
        $zbwLine = [
            0 => 'BOS_CTR',
            4 => '134.700'
        ];
        $line = [
            0 => 'JFK_TWR',
            4 => '122.500'
        ];
        $this->resource = new DatafeedLine($zbw ? $zbwLine : $line);
        $this->checkInstance($this->resource);
    }

    private function setInvalidPosition()
    {
        $invalidLine = [
            0 => 'ABC123',
            4 => '199.999'
        ];
        $this->resource = new DatafeedLine($invalidLine);
    }

    private function checkInstance($instance)
    {
        $this->assertInstanceOf(DatafeedLine::class, $instance);
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->checkInstance($this->resource);
    }

    /**
    * @test
    */
    public function validatesFlight()
    {
        $this->setFlightLine(true);
        $this->assertTrue($this->resource->isZbwFlight());
        $this->setFlightLine(false);
        $this->assertFalse($this->resource->isZbwFlight());
    }

    /**
    * @test
    */
    public function validatesAirport()
    {
        $this->setAirportLine(true);
        $this->assertTrue($this->resource->isZbwAirport());
        $this->setAirportLine(false);
        $this->assertFalse($this->resource->isZbwAirport());
    }

    /**
    * @test
    */
    public function detectsInvalidPositions()
    {
        $this->setInvalidPosition();
        $this->assertTrue($this->resource->hasInvalidPosition());
        $this->setAirportLine(true);
        $this->assertFalse($this->resource->hasInvalidPosition());
    }
}

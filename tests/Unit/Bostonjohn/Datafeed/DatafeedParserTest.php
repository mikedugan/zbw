<?php namespace Tests\Unit\Bostonjohn\Datafeed;

use Zbw\Bostonjohn\Datafeed\DatafeedParser;

class DatafeedParserTest extends \PHPUnit_Framework_TestCase
{
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $curl = \Mockery::mock(Curl::class);
        $curl->shouldReceive('get')->with('http://vatsim.aircharts.org/vatsim-data.txt')->andReturnNull();
        $curl->shouldReceive('close')->andReturnNull();
        $curl->response = 'foo';
        $this->resource = new DatafeedParser($curl);
        $this->resource->setFlightModel(TestFlight::class);
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(DatafeedParser::class, $this->resource);
    }

    /**
    * @test
    */
    public function parsesEmptyDatafeed()
    {
        $this->assertNull($this->resource->parseDatafeed());
    }

    /**
    * @test
    */
    public function parsesCompleteDatafeed()
    {
        $curl = \Mockery::mock(Curl::class);
        $curl->shouldReceive('get')->with('http://vatsim.aircharts.org/vatsim-data.txt')->andReturnNull();
        $curl->shouldReceive('close')->andReturnNull();
        $curl->response = file_get_contents(__DIR__.'/datafeed.txt');
        $this->resource = new DatafeedParser($curl);
        $this->resource->setFlightModel(TestFlight::class);
        $this->assertNull($this->resource->parseDatafeed());
    }
}

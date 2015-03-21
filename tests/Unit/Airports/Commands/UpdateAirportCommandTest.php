<?php namespace Tests\Unit\Airports\Commands;

use Zbw\Airports\Commands\UpdateAirportCommand;
use Zbw\Airports\IcaoCode;

class UpdateAirportCommandTest extends \PHPUnit_Framework_TestCase
{
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $this->resource = new UpdateAirportCommand('kbos', ['foo' => 'bar']);
    }

    /**
    * @test
    */
    public function commandInstantiated()
    {
        $this->assertInstanceOf(UpdateAirportCommand::class, $this->resource);
    }

    /**
    * @test
    */
    public function commandDataInstantiated()
    {
        $this->assertInstanceOf(IcaoCode::class, $this->resource->icao);
        $this->assertEquals('bar', $this->resource->data['foo']);
    }
}

<?php namespace Tests\Functional\Airports\Handlers;

use Zbw\Airports\Commands\UpdateAirportCommand;
use Zbw\Airports\Handlers\UpdateAirportHandler;
use Tests\TestCase;

class UpdateAirportHandlerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->command = new UpdateAirportCommand('KBLS', ['iata' => 'BLS']);
        $this->resource = new UpdateAirportHandler(new \Zbw\Airports\EloquentAirportRepository());
    }

    public function testTargetsAreInstantiated()
    {
        $this->assertInstanceOf(UpdateAirportHandler::class, $this->resource);
        $this->assertInstanceOf(UpdateAirportCommand::class, $this->command);
    }

    public function testCommandHasValidData()
    {
        $this->assertEquals('KBLS', $this->command->icao->icao());
        $this->assertEquals('BLS', $this->command->data['iata']);
    }

    public function testHandlesCommandMissingAirport()
    {
        $response = $this->resource->handle($this->command);
        $this->assertEquals('KBLS not found', $response->getFlashData()['flash_error']);
    }

}

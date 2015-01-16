<?php namespace Tests\Unit\Airports;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zbw\Airports\Frequency;

class FrequencyTest extends \PHPUnit_Framework_TestCase
{
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $this->resource = new Frequency();
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(Frequency::class, $this->resource);
    }

    /**
    * @test
    */
    public function belongsToAirport()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->resource->airport());
    }
}

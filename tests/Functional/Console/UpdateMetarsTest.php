<?php namespace Tests\Functional\Console;

use Tests\TestCase;
use Zbw\Console\UpdateMetars;

class UpdateMetarsTest extends TestCase
{
    private $resource;

    public function setUp()
    {
        parent::setUp();
        $this->resource = new UpdateMetars();
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(UpdateMetars::class, $this->resource);
    }
}

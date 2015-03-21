<?php namespace Tests\Unit\Users;

use Zbw\Users\StaffingFactory;

class StaffingFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var StaffingFactory */
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $this->resource = new StaffingFactory();
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(StaffingFactory::class, $this->resource);
    }

    /**
    * @test
    */
    public function createsStaffingFromDatafeedLine()
    {
        $line = [];
        $line[0] = 'ABC123';
        $line[1] = '00112233';
        $line[2] = 'foo';
        $line[3] = 'bar';
        $line[4] = '123.321';
        $start = '12-12-2015 01:10:00';
        $staffing = $this->resource->fromDatafeedLine($line, $start);
        $this->assertInstanceOf(\Staffing::class, $staffing);
        $this->assertEquals('00112233', $staffing->cid);
    }
}

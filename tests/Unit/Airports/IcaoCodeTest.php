<?php namespace Tests\Unit\Airports;

use Zbw\Airports\IcaoCode;

class IcaoCodeTest extends \PHPUnit_Framework_TestCase
{
    private $resource;

    public function setUp()
    {
        parent::setUp();
        $this->resource = IcaoCode::fromCode('KBOS');
    }

    /**
     * @test
     */
    public function codeIsInstantiated()
    {
        $this->assertInstanceOf(IcaoCode::class, $this->resource);
    }

    /**
     * @test
     */
    public function codeChecksEquality()
    {
        $bos = IcaoCode::fromCode('KBOS');
        $pvd = IcaoCode::fromCode('KPVD');
        $this->assertTrue($this->resource->equals($bos));
        $this->assertFalse($this->resource->equals($pvd));
    }

    /**
     * @test
     */
    public function codeChecksValidity()
    {
        $this->assertTrue($this->resource->isValid());
        $this->resource = IcaoCode::fromCode('fooBarBaz');
        $this->assertFalse($this->resource->isValid());
    }

    /**
    * @test
    */
    public function returnsRawCode()
    {
        $this->assertEquals('KBOS', $this->resource->icao());
    }
}

<?php  namespace Tests\Unit\Bostonjohn\Datafeed; 

use Zbw\Bostonjohn\Datafeed\EloquentMetarRepository;

class MetarRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $resource;
    public function setUp()
    {
        parent::setUp();
        $this->resource = new EloquentMetarRepository();
    }

    /**
    * @test
    */
    public function resourceInstantiated()
    {
        $this->assertInstanceOf(EloquentMetarRepository::class, $this->resource);
    }

    /**
    * @test
     * @expectedException \BadMethodCallException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage Cannot update METARs
    */
    public function updateThrowsException()
    {
        $this->resource->update('foo');
    }
}

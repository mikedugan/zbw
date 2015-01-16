<?php  namespace Tests\Functional\Bostonjohn\Datafeed; 

use Tests\TestCase;
use Zbw\Bostonjohn\Datafeed\EloquentMetarRepository;

class EloquentMetarRepositoryTest extends TestCase
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
    public function retrievesStaleMetars()
    {
        $stale = $this->resource->getStaleMetars();
        $this->assertTrue(is_array($stale));
        $this->assertGreaterThan(1, $stale);
    }
}

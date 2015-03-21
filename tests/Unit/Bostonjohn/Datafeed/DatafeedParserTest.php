<?php namespace Tests\Unit\Bostonjohn\Datafeed;

use Illuminate\Database\Eloquent\Collection;
use Zbw\Bostonjohn\Datafeed\DatafeedParser;
use Zbw\Users\Contracts\StaffingRepositoryInterface;

class DatafeedParserTest extends \PHPUnit_Framework_TestCase
{
    protected $resource;
    
    public function setUp()
    {
        parent::setUp();
        $curl = \Mockery::mock(Curl::class);
        $curl->shouldReceive('get')->with('http://vatsim.aircharts.org/vatsim-data.txt')->andReturnNull();
        $curl->shouldReceive('close')->andReturnNull();
        $curl->response = 'ROU1811:1289337:Yosh Seidner KBOS:PILOT::36.51790:-80.56025:35188:435:B763:475:MMUN:35000:CYYZ:USA-E:100:1:1200:::1:I:2055:2055:3:25:4:45:CYXU:+VFPS+/V/PBN/A1B1C1D1L1O1 NAV/RNVD1E2A1 DOF/150115 REG/CFMWQ EET/KZHU0030 KZMA0049 KZJX0110 KZTL0207 KZDC0226 KZOB0242 CZYZ0312 SEL/CQJS TALT/MMMD RMK/TCAS EQPT RMK/SIMBRIEF:CUN1A CUN UM219 MYDIA M219 CIGAR LOULO J55 CRG/N0465F370 J51 CAE RICCS LINNG5:0:0:0:0:::20150116185822:2:30.09:1018:';
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
        $staffings = \Mockery::mock(Collection::class);
        $staffings->shouldReceive('count')->andReturn(0);
        $staffingsRepo = \Mockery::mock(StaffingRepositoryInterface::class);
        $staffingsRepo->shouldReceive('getDaysOfStaffing')->with(2)->andReturn($staffings);
        $staffingsRepo->shouldReceive('save')->andReturn(true);
        $curl->response = 'ROU1811:1289337:Yosh Seidner KBOS:PILOT::36.51790:-80.56025:35188:435:B763:475:MMUN:35000:CYYZ:USA-E:100:1:1200:::1:I:2055:2055:3:25:4:45:CYXU:+VFPS+/V/PBN/A1B1C1D1L1O1 NAV/RNVD1E2A1 DOF/150115 REG/CFMWQ EET/KZHU0030 KZMA0049 KZJX0110 KZTL0207 KZDC0226 KZOB0242 CZYZ0312 SEL/CQJS TALT/MMMD RMK/TCAS EQPT RMK/SIMBRIEF:CUN1A CUN UM219 MYDIA M219 CIGAR LOULO J55 CRG/N0465F370 J51 CAE RICCS LINNG5:0:0:0:0:::20150116185822:2:30.09:1018:';
        $this->resource = new DatafeedParser($curl, $staffingsRepo);
        $this->resource->setFlightModel(TestFlight::class);
        $this->assertNull($this->resource->parseDatafeed());
    }
}

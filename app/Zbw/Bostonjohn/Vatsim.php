<?php  namespace Zbw\Bostonjohn;

use Curl\Curl;
use Zbw\Helpers;
use Carbon\Carbon;

class Vatsim {
    private $status_url;
    public $curl;

    public function __construct()
    {
        $this->resetCurl();
        $this->status_url = \Config::get('zbw.vatsim_status');
    }

    /**
     * @name updateStatus
     * @description updates the vatsim datafeeds
     * @return bool
     */
    public function updateStatus()
    {
        $this->getStatus();
        return $this->save($this->parseStatus());
    }

    public function updateMetars()
    {
        $url = \Datafeed::where('key', 'metar')->get();
    }

    /**
     * @name resetCurl
     * @description resets the curl object
     * @return void
     */
    private function resetCurl()
    {
        $this->curl = new Curl();
    }

    /**
     * @name getStatus
     * @description retrieves the vatsim status page
     * @return void
     */
    private function getStatus()
    {
        $this->curl->get($this->status_url);
    }

    /**
     * @name parseStatus
     * @description parses the status page into urls
     * @return array
     */
    private function parseStatus()
    {
        $lines = Helpers::makeLines($this->curl->response);
        $servers = $data = $atis = $metar = $user = '';
        foreach($lines as $line) {
            if($line[0] == ';') continue;
            $parts = explode('=', $line);
            switch($parts[0]) {
                case 'url0':
                    if(empty($data))
                        $data = $parts[1];
                    break;
                case 'url1':
                    if(empty($servers))
                        $servers = $parts[1];
                    break;
                case 'metar0':
                    if(empty($metar))
                        $metar = $parts[1];
                    break;
                case 'atis0':
                    if(empty($atis))
                        $atis = $parts[1];
                    break;
                case 'user0':
                    if(empty($user))
                        $user = $parts[1];
                    break;
                default:
                    break;
            }
        }
        return ['servers' => $servers, 'data' => $data, 'atis' => $atis, 'metar' => $metar, 'user' => $user];
    }

    /**
     * @name  save
     * @description saves the datafeed urls
     * @param $data
     * @return bool
     */
    private function save($data)
    {
        $ret = true;
        foreach ($data as $k => $v) {
            $df = new \Datafeed([
                  'key' => $k,
                  'value' => $v,
              ]);
            $df->expires = Carbon::now()->addDay();
            if(! $df->save()) $ret = false;
        }
        return $ret;
    }
} 

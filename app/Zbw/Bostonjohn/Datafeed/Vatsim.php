<?php  namespace Zbw\Bostonjohn\Datafeed;

use Curl\Curl;
use Zbw\Core\Helpers;
use Carbon\Carbon;
use Zbw\Bostonjohn\Datafeed\Contracts\VatsimDataInterface;

/**
 * @package Bostonjohn
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class Vatsim implements VatsimDataInterface
{
    private $status_url;
    public $curl;

    public function __construct()
    {
        $this->resetCurl();
        $this->status_url = \Config::get('zbw.vatsim_status');
    }

    /**
     * Updates the vatsim datafeeds
     *
     * @return bool
     */
    public function updateStatus()
    {
        $this->getStatus();
        return $this->save($this->parseStatus());
    }

    /**
     * Resets the curl object
     *
     * @return void
     */
    private function resetCurl()
    {
        $this->curl = new Curl();
    }

    /**
     * Retrieves the vatsim status page
     *
     * @return void
     */
    private function getStatus()
    {
        $this->curl->get($this->status_url);
    }

    /**
     * Parses the status page into urls
     *
     * @return array
     */
    private function parseStatus()
    {
        $lines = Helpers::makeLines($this->curl->response);
        $servers = $data = $atis = $metar = $user = '';

        $all_data = [];

        foreach($lines as $line) {
            if($line[0] == ';') continue;
            $parts = explode('=', $line);
            switch($parts[0]) {
                case 'url0':
                        $all_data[] = $parts[1];
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

        shuffle($all_data);
        $data = array_pop($all_data);
        echo "new datafeed: $data";
        return ['servers' => $servers, 'data' => $data, 'atis' => $atis, 'metar' => $metar, 'user' => $user];
    }

    /**
     * Saves the datafeed urls
     *
     * @param $data
     * @return bool
     */
    private function save($data)
    {
        foreach ($data as $k => $v) {
            $df = new \Datafeed();
            $df->key = $k;
            $df->value = $v;
            $df->expires = \Carbon::now()->addDay();
            $df->save();
            echo $df->key ." added\n";
        }
        return true;
    }
} 

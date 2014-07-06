<?php  namespace Zbw\Bostonjohn;

use Curl\Curl;

class MetarCreator {

    private $curl;

    public function __construct()
    {
        $this->curl = new Curl();
    }

    public function updateMetars()
    {
        $airports = \Config::get('zbw.metar_airports');
        $url = \Datafeed::where('key', 'metar')->first();
        foreach($airports as $airport)
        {
            $this->curl->get($url->value, ['id' => $airport]);
            $parser = new MetarParser($this->curl->response);
            $lastMetar = \Metar::where('facility', $airport)->latest()->first();
            $response = $this->curl->response;
            if(empty($response) || empty($lastMetar->raw)) { echo "empty"; continue; }
            if($lastMetar->raw != $response) {
                echo "not empty";
                $this->createMetar($airport, $parser);
            }
        }
    }

    /**
     * @name  createMetar
     * @description
     * @param string $airport
     * @param MetarParser $parser
     * @return void
     */
    private function createMetar($airport, $parser)
    {
        if(! preg_match('/No METAR available/', $this->curl->response)) {
            $metar = new \Metar();
            $metar->facility = $airport;
            $metar->raw = trim($this->curl->response);
            $metar->time = $parser->getZuluTime();
            $metar->wind_direction = $parser->getWindDirection();
            $metar->wind_speed = $parser->getWindSpeed();
            $metar->wind_gusts = $parser->getWindGusts();
            $metar->visibility = $parser->getVisibility();
            $metar->sky = json_encode($parser->getCloudCover());
            $metar->temp = $parser->getTemperature();
            $metar->dewpoint = $parser->getDewpoint();
            $metar->altimeter = $parser->getQNH();
            $metar->save();
        }
    }
} 

<?php namespace Zbw\Core\Repositories; 

use Zbw\Core\EloquentRepository;

class MetarRepository extends EloquentRepository
{
    public $model = '\Metar';

    public function frontPage()
    {
        $ret = [];
        $airports = \Config::get('zbw.front_page_metars');
        foreach($airports as $airport) {
            $ret[] = $this->make()->where('facility', $airport)->latest()->first();
        }

        return $ret;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function update($input)
    {
    }
}

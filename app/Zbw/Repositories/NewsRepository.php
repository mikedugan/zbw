<?php namespace Zbw\Repositories;

use \News as News;

class NewsRepository {
    public function front($lim)
    {
        return News::where('audience', '=', 'both')->where('news_type', '!=', '4')->limit($lim)->get();
    }

    public function events($num)
    {

    }
}

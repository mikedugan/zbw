<?php namespace Zbw\Repositories;

use \News as News;

class NewsRepository {
    public function front($lim)
    {
        return News::where('audience', '=', 'both')->where('news_type', '!=', '4')->limit($lim)->get();
    }

    public static function staffNews($lim, $direction = 'DESC')
    {
        return \News::where('news_type', '=', 5)->limit($lim)->orderBy('starts', $direction)->get();
    }

    public static function recentNews($num, $direction = 'DESC')
    {
        return \News::where('news_type', '!=', 5)->where('news_type', '!=', 1)
                ->limit($num)->orderBy('starts', $direction)->get();
    }

    public static function events()
    {
        return \News::where('news_type', '=', '1')->get();
    }

    public static function activeEvents()
    {
        return \News::where('ends', '>', \Carbon::now())->get();
    }

    public static function expiredEvents()
    {
        return \News::where('ends', '<', \Carbon::now())->where('news_type', '=', 1)->get();
    }

    public static function upcomingEvents($lim)
    {
        return \News::where('starts', '>', \Carbon::now())->orderBy('starts')->limit($lim)->get();
    }
}

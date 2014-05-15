<?php namespace Zbw\Repositories;

use \News as News;
use Zbw\Interfaces\EloquentRepositoryInterface;
use Zbw\Validators\ZbwValidator;

class NewsRepository implements EloquentRepositoryInterface {
    /** methods */

    public function front($lim)
    {
        return News::where('audience_type_id', '=', '1')->where('news_type_id', '!=', '5')->limit($lim)->get();
    }

    /** static functions */
    public static function all()
    {
        return \News::all();
    }

    public static function find($id, $relations)
    {
        return \News::with($relations)->find($id);
    }

    public static function findWithRelations($id)
    {
        return \News::with(['Facility'])->find($id);
    }

    public static function add($input)
    {
        $invalid = ZbwValidator::get('News', $input);

        //if validation fails, return the errors
        if(is_array($invalid)) return $invalid;

        //just in case a user forgot to properly set the date on the news
        $starts = '';
        $ends = '';
        if( ! $input['starts']) { $starts = \Carbon::now(); }
        else { $starts = \Carbon::createFromFormat('Y/m/d H:i', $input['starts']); }
        if( ! $input['ends']) { $ends = \Carbon::now()->addWeek(); }
        else { $ends = \Carbon::createFromFormat('Y/m/d H:i', $input['ends']); }

        //create the object
        $n = \News::create([
            'title' => $input['title'],
            'starts' => $starts,
            'ends' => $ends,
            'news_type_id' => $input['news_type'],
            'content' => $input['content'],
            'facility_id' => $input['facility'],
            'audience_type_id' => $input['audience']
        ]);
        //return the save result
        return $n->save();
    }

    public static function delete($id)
    {
        return \News::destroy($id);
    }

    public static function staffNews($lim, $direction = 'DESC')
    {
        return \News::where('news_type_id', '=', 5)->limit($lim)->orderBy('starts', $direction)->get();
    }

    public static function recentNews($num, $direction = 'DESC')
    {
        return \News::where('news_type_id', '!=', 5)->where('news_type_id', '!=', 1)
                ->limit($num)->orderBy('starts', $direction)->get();
    }

    public static function events()
    {
        return \News::where('news_type_id', '=', '1')->get();
    }

    public static function activeEvents()
    {
        return \News::where('ends', '>', \Carbon::now())->where('starts', '<', \Carbon::now())->get();
    }

    public static function expiredEvents($lim, $sortBy = 'ends', $direction = 'DESC')
    {
        return \News::where('ends', '<', \Carbon::now())->where('news_type_id', '=', 1)->limit($lim)->orderBy($sortBy, $direction)->get();
    }

    public static function upcomingEvents($lim)
    {
        return \News::where('starts', '>', \Carbon::now())->orderBy('starts')->limit($lim)->get();
    }
}

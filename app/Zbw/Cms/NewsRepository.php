<?php namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Validators\BaseValidator;
use Zbw\Cms\Contracts\NewsRepositoryInterface;

class NewsRepository extends EloquentRepository implements NewsRepositoryInterface
{
    public $model = '\News';

    public function front($lim)
    {
        return $this->make()->where('audience_type_id', '=', '1')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->limit($lim)->get();
    }

    public function controllers($lim = null)
    {
        if($lim) {
            return $this->make()->with(['facility'])->where('audience_type_id', '!=', '1')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->limit($lim)->get();
        } else {
            return $this->make()->with(['facility'])->where('audience_type_id', '!=', '1')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->get();
        }
    }

    public function pilots($lim = null)
    {
        if($lim) {
            return $this->make()->with(['facility'])->where('audience_type_id', '=', '2')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->limit($lim)->get();
        } else {
            return $this->make()->with(['facility'])->where('audience_type_id', '!=', '2')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->get();
        }
    }

    /** functions */
    public function all()
    {
        return $this->make()->all();
    }

    public function find($id, $relations = null)
    {
        return $relations ? $this->make()->with($relations)->find($id) : $this->make()->find($id);
    }

    public function findWithRelations($id)
    {
        return $this->make()->with(['Facility'])->find($id);
    }

    public function add($input)
    {
        //just in case a user forgot to properly set the date on the news
        /*if( ! $input['starts']) { $starts = \Carbon::now(); }
        else { $starts = \Carbon::createFromFormat('Y/m/d H:i', $input['starts']); }
        if( ! $input['ends']) { $ends = \Carbon::now()->addWeek(); }
        else { $ends = \Carbon::createFromFormat('Y/m/d H:i', $input['ends']); }*/
        //create the object
        $n = new $this->model;
        $n->title =  $input['title'];
        $n->starts =  $input['starts'];
        $n->ends =  $input['ends'];
        $n->news_type_id =  $input['news_type'];
        $n->content =  $input['content'];
        $n->facility_id =  $input['facility'];
        $n->audience_type_id = $input['audience'];
        //return the save result
        if($n->save()) {
            return true;
        }
        else {
           $this->setErrors($n->getErrors());
            return false;
        }
    }

    public function update($input)
    {
        $invalid = BaseValidator::get('News', $input);
        if(is_array($invalid)) return $invalid;
        $input['starts'] = \Carbon::createFromFormat('Y-m-d H:i:s', $input['starts']);
        $input['ends'] = \Carbon::createFromFormat('Y-m-d H:i:s', $input['ends']);

        return $this->make()->find($input['event_id'])->fill($input)->save();
    }

    public function delete($id)
    {
        return $this->make()->destroy($id);
    }

    public function staffNews($lim, $direction = 'DESC')
    {
        return $this->make()->where('news_type_id', '=', 5)->limit($lim)->orderBy('starts', $direction)->get();
    }

    public function recentNews($num, $direction = 'DESC')
    {
        return $this->make()->where('news_type_id', '!=', 5)->where('news_type_id', '!=', 1)
                ->limit($num)->orderBy('starts', $direction)->get();
    }

    public function events()
    {
        return $this->make()->where('news_type_id', '=', '1')->get();
    }

    public function activeEvents()
    {
        return $this->make()->where('ends', '>', \Carbon::now())->where('starts', '<', \Carbon::now())->get();
    }

    public function expiredEvents($lim, $sortBy = 'ends', $direction = 'DESC')
    {
        return $this->make()->where('ends', '<', \Carbon::now())->where('news_type_id', '=', 1)->limit($lim)->orderBy($sortBy, $direction)->get();
    }

    public function upcomingEvents($lim)
    {
        return $this->make()->where('starts', '>', \Carbon::now())->orderBy('starts')->limit($lim)->get();
    }

    public function create($input)
    {

    }
}

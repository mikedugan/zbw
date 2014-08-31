<?php namespace Zbw\Cms;

use Zbw\Core\EloquentRepository;
use Zbw\Cms\Contracts\NewsRepositoryInterface;

/**
 * @package Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class NewsRepository extends EloquentRepository implements NewsRepositoryInterface
{
    /**
     * @var string
     */
    public $model = '\News';

    /**
     * @param $lim
     * @return mixed
     */
    public function front($lim)
    {
        return $this->make()->where('audience_type_id', '=', '1')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->limit($lim)->get();
    }

    /**
     * @param null $lim
     * @return mixed
     */
    public function controllers($lim = null)
    {
        if($lim) {
            return $this->make()->with(['facility'])->where('audience_type_id', '!=', '1')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->limit($lim)->get();
        } else {
            return $this->make()->with(['facility'])->where('audience_type_id', '!=', '1')->where('news_type_id', '!=', '5')->orderBy('created_at', 'DESC')->get();
        }
    }

    /**
     * @param null $lim
     * @return mixed
     */
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

    /**
     * @param      $id
     * @param null $relations
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static
     */
    public function find($id, $relations = null)
    {
        return $relations ? $this->make()->with($relations)->find($id) : $this->make()->find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static
     */
    public function findWithRelations($id)
    {
        return $this->make()->with(['Facility'])->find($id);
    }

    /**
     * @param $input
     * @return bool
     */
    public function add($input)
    {
        $n = new $this->model;
        $n->title = $input['title'];
        $n->starts = \Carbon::createFromFormat('m-d-Y H:i:s', $input['starts']);
        $n->ends = \Carbon::createFromFormat('m-d-Y H:i:s', $input['ends']);;
        $n->news_type_id = $input['news_type'];
        $n->content = $input['content'];
        $n->facility_id = $input['facility'];
        $n->audience_type_id = $input['audience'];
        //return the save result
        return $this->checkAndSave($n);
    }

    /**
     * @param $input
     * @return bool
     */
    public function update($input)
    {
        $input['starts'] = \Carbon::createFromFormat('Y-m-d H:i:s', $input['starts']);
        $input['ends'] = \Carbon::createFromFormat('Y-m-d H:i:s', $input['ends']);

        $n = $this->make()->find($input['event_id']);
        $n->title =  $input['title'];
        $n->starts =  $input['starts'];
        $n->ends =  $input['ends'];
        $n->news_type_id =  $input['news_type_id'];
        $n->content =  $input['content'];
        $n->facility_id =  $input['facility_id'];
        $n->audience_type_id = $input['audience_type_id'];

        return $this->checkAndSave($n);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->make()->destroy($id);
    }

    /**
     * @param        $lim
     * @param string $direction
     * @return mixed
     */
    public function staffNews($lim, $direction = 'DESC')
    {
        return $this->make()->where('news_type_id', '=', 5)->limit($lim)->orderBy('starts', $direction)->get();
    }

    /**
     * @param        $num
     * @param string $direction
     * @return mixed
     */
    public function recentNews($num, $direction = 'DESC')
    {
        return $this->make()->where('news_type_id', '!=', 5)->where('news_type_id', '!=', 1)
                ->limit($num)->orderBy('starts', $direction)->get();
    }

    /**
     * @return mixed
     */
    public function events()
    {
        return $this->make()->where('news_type_id', '=', '1')->get();
    }

    /**
     * @return mixed
     */
    public function activeEvents()
    {
        return $this->make()->where('ends', '>', \Carbon::now())->where('starts', '<', \Carbon::now())->get();
    }

    /**
     * @param        $lim
     * @param string $sortBy
     * @param string $direction
     * @return mixed
     */
    public function expiredEvents($lim, $sortBy = 'ends', $direction = 'DESC')
    {
        return $this->make()->where('ends', '<', \Carbon::now())->where('news_type_id', '=', 1)->limit($lim)->orderBy($sortBy, $direction)->get();
    }

    /**
     * @param $lim
     * @return mixed
     */
    public function upcomingEvents($lim)
    {
        return $this->make()->where('starts', '>', \Carbon::now())->orderBy('starts')->limit($lim)->get();
    }

    /**
     * @param $input
     * @return void
     */
    public function create($input)
    {

    }
}

<?php namespace Zbw\Training;

use Zbw\Base\EloquentRepository;
use Zbw\Training\Contracts\TrainingSessionRepositoryInterface;
use Zbw\Users\UserRepository;

class TrainingSessionRepository extends EloquentRepository implements TrainingSessionRepositoryInterface
{
    private $users;
    public $model = '\TrainingSession';
    /**
     * @param array $input
     * @return mixed array|boolean
     */

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function create($input)
    {
        $ts = new \TrainingSession;
        $ts->session_date = $input['date'];
        $ts->weather_id = $input['weather'];
        $ts->complexity_id = $input['complexity'];
        $ts->workload_id = $input['workload'];
        $ts->staff_comment = $input['staff_comment'];
        $ts->is_ots = isset($input['ots']) ? true : false;
        $ts->facility_id = $input['facility_id'];
        $ts->brief_time = $input['brief_time'];
        $ts->position_time = $input['position_time'];
        $ts->is_live = isset($input['live']) ? true: false;
        $ts->training_type_id = $input['training_type'];
        $ts->cid = $input['cid'];
        $ts->sid = $input['sid'];
        return $this->checkAndSave($ts);
    }

    public function update($input)
    {

    }

    /**
     * @param integer number of reports
     * @return EloquentCollection
     */
    public static function recentReports($n)
    {
        return \TrainingSession::with(['student', 'staff', 'facility'])
            ->orderBy('updated_at', 'DESC')->limit($n)->get();
    }

    public function indexPaginated($n, $with = ['student', 'staff', 'facility'])
    {
        return $this->make()->with($with)->paginate($n);
    }

    public function indexFiltered($input)
    {
        $ret = $this->make()->with(['student','staff','facility']);
        if(array_key_exists('cinitials', $input)) {
            $user = $this->users->findByInitials($input['cinitials']);
            if($user) $ret->where('cid', $user->cid);
        }
        if(array_key_exists('sinitials', $input)) {
            $user = $this->users->findByInitials($input['sinitials']);
            if($user) $ret->where('sid', $user->cid);
        }
        if(array_key_exists('before', $input) && ! empty($input['before'])) {
            $ret->where('created_at', '<', \Carbon::createFromFormat('m-d-Y H:i:s', $input['before']));
        }
        if(array_key_exists('after', $input) && ! empty($input['after'])) {
            $ret->where('created_at', '>', \Carbon::createFromFormat('m-d-Y H:i:s', $input['after']));
        }
        return $ret->get();
    }

}

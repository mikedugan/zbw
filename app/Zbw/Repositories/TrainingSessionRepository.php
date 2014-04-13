<?php namespace Zbw\Repositories;

use Zbw\Interfaces\EloquentRepositoryInterface;

class TrainingSessionRepository implements EloquentRepositoryInterface {
    /**
     * @param integer $id
     * @return \TrainingSession
     */
    public static function find($id)
    {
        return \TrainingSession::find($id);
    }

    /**
     * @return EloquentCollection
     */
    public static function all()
    {
        return \TrainingSession::all();
    }

    /**
     * @param integer training session id
     * @return \TrainingSession
     * @todo add the relations to be eager loaded
     */
    public static function findWithRelations($id)
    {
        return \TrainingSession::with(['WeatherType', 'ComplexityType', 'WorkloadType', 'Student', 'Instructor',
            'TrainingType', 'Facility', 'TrainingReport'])->find($id);
    }

    public static function findWith($id, $relations)
    {
        return \TrainingSession::with($relations)->find($id);
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    public static function add($input)
    {
        $invalid = ZbwValidator::get('TrainingSession', $input);

        //if validation fails, return the errors
        if(is_array($invalid)) return $invalid;
        $session = \TrainingSession::create([
            'session_date' => $input['date'],
            'weather_id' => $input['weather'],
            'complexity_id' => $input['complexity'],
            'workload_id' => $input['workload'],
            'staff_comment' => $input['staff_comment'],
            'is_ots' => isset($input['ots']) ? true : false,
            'facility_id' => $input['facility_id'],
            'brief_time' => $input['brief_time'],
            'position_time' => $input['position_time'],
            'is_live' => isset($input['live']) ? true: false,
            'training_type_id' => $input['training_type']
        ]);
        $session->cid = $input['cid'];
        $session->sid = $input['sid'];
        return $session->save();
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public static function delete($id)
    {
        return \TrainingSession::destroy($id);
    }

    /**
     * @param integer number of reports
     * @return EloquentCollection
     */
    public static function recentReports($n)
    {
        return \TrainingSession::with(['student', 'staff', 'facility'])
            ->orderBy('created_at')->limit($n)->get();
    }

}

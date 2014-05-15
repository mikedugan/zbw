<?php namespace Zbw\Repositories;

use Zbw\Interfaces\EloquentRepositoryInterface;

class TrainingSessionRepository implements EloquentRepositoryInterface {

    /**
     * @type static
     * @name find
     * @description return a user with optional relations
     * @param int $id
     * @param mixed $relations
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static
     */
    public static function find($id, $relations)
    {
        $allRelations = ['WeatherType', 'ComplexityType', 'WorkloadType', 'Student', 'Staff',
            'TrainingType', 'Facility', 'TrainingReport'];

        return $relations === "all" ? \TrainingSession::with($allRelations)->find($id) : \TrainingSession::with($relations)->find($id);
    }

    /**
     * @return EloquentCollection
     */
    public static function all()
    {
        return \TrainingSession::all();
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

<?php namespace Zbw\Training;

use Zbw\Base\EloquentRepository;

class TrainingSessionRepository extends EloquentRepository {
    public $model = '\TrainingSession';
    /**
     * @param array $input
     * @return mixed array|boolean
     */
    public function create($input)
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
            ->orderBy('created_at')->limit($n)->get();
    }

}

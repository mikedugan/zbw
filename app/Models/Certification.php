<?php

/**
 * Certification
 *
 * @property integer $id
 * @property integer $cid
 * @property boolean $cert_type_id
 * @property boolean $passed
 * @property boolean $times_taken
 * @property string $first_exam
 * @property string $last_exam
 * @property string $first_request
 * @property string $last_request
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Certification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereCertTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification wherePassed($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereTimesTaken($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereFirstExam($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereLastExam($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereFirstRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereLastRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Certification whereUpdatedAt($value)
 */
class Certification extends BaseModel {
	protected $guarded = ['cid', 'passed'];
	protected $table = 'controller_certs';
	static $rules = [
      'cid' => 'cid',
      'exam_id' => 'integer|between:1,10',
      'times_taken' => 'integer',
      'first_exam' => 'date',
      'last_exam' => 'date',
      'first_request' => 'date',
      'last_request' => 'date'
  ];
}

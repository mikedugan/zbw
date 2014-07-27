<?php

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

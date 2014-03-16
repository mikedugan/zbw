<?php

class PendingExam extends Eloquent {
    protected $fillable = ['cid', 'exam_id', 'cert_id'];
	protected $table = '_pending_exams';
}

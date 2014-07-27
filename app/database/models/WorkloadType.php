<?php

class WorkloadType extends BaseModel {
    protected $fillable = ['type'];
	protected $table = '_workload_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
}

<?php

class WorkloadType extends Eloquent {
    protected $fillable = ['type'];
	protected $table = '_workload_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
}

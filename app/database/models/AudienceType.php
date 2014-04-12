<?php

class AudienceType extends Eloquent {
    protected $fillable = ['type'];
	protected $table = '_audience_types';
    public $timestamps = false;
}

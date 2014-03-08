<?php

class AudienceType extends Eloquent {
    protected $fillable = ['type'];
	protected $table = '_news_audience';
    public $timestamps = false;
}

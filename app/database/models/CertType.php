<?php

class CertType extends Eloquent {
    protected $fillable = ['value'];
	protected $table = '_cert_types';
    public $timestamps = false;
}

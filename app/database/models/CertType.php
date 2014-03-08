<?php

class CertType extends Eloquent {
    protected $fillable = ['type'];
	protected $table = '_cert_types';
    public $timestamps = false;
}
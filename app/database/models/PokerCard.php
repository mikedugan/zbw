<?php

class PokerCard extends Eloquent {
	protected $guarded = [];
	protected $table = 'zbw_pokercards';
	public $rules = [];
    public $dates = ['discarded'];
}

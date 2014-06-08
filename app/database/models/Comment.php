<?php

class Comment extends Eloquent {
    protected $guarded = ['author'];
    protected $table = 'zbw_comments';
    public $rules = [
        'cid' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo('User', 'author', 'cid');
    }
}

<?php

class Comment extends BaseModel {
    protected $guarded = ['author'];
    protected $table = 'zbw_comments';
    static $rules = [
        'author' => 'integer',
        'content' => 'required',
        'parent_id' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo('User', 'author', 'cid');
    }
}

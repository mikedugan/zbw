<?php 

class FileUpload extends Eloquent
{
    protected $table = 'zbw_uploads';
    protected $guarded = ['location', 'name'];
    public static $rules = [
        'parent_id' => 'integer',
        'name' => 'max:60',
        'description' => 'max:120',
        'type' => 'integer',
        'mime' => 'mimes:jpeg,jpg,png,gif,doc,docx,txt,sct,sct2'
    ];
}

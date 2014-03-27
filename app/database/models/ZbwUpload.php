<?php 

class FileUpload extends Eloquent
{
    protected $table = 'zbw_uploads';
    protected $guarded = ['location', 'name'];
}

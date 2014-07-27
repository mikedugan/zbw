<?php 

class Upload extends BaseModel
{
    protected $table = 'zbw_uploads';
    protected $guarded = ['location', 'name'];
}

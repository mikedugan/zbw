<?php 

class FileType extends BaseModel
{
    protected $table = '_file_types';
    protected $fillable = ['type'];
    public $timestamps = false;
} 

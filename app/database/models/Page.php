<?php 

class Page extends Eloquent
{
    protected $guarded = ['author'];
    protected $table = 'zbw_pages';
} 

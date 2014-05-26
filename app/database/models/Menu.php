<?php 

class Menu extends Eloquent
{
    protected $guarded = [''];
    protected $table = 'zbw_menus';

    //relations
    public function pages()
    {
        return $this->hasMany('Page', 'menu_id', 'id');
    }

    public function getUrlTitle()
    {
        return str_replace(' ', '_', strtolower($this->title));
    }
} 

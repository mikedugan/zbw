<?php 

class Page extends Eloquent
{
    protected $guarded = ['author'];
    protected $table = 'zbw_pages';

    //relations
    public function menu()
    {
        return $this->belongsTo('Menu', 'id', 'menu_id');
    }
    //scopes

    public function scopeStaff($q)
    {
        //TODO implement
    }

    public function scopePilots($q)
    {
        //TODO implement
    }

    public function scopeControllers($q)
    {
        //TODO implement
    }

    public function getUrlPath()
    {
        $menu = $this->menu->getUrlTitle();
        return $menu . '/' . str_replace(' ','_', strtolower($this->title));
    }
}

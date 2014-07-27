<?php 

class Page extends Eloquent
{
    protected $guarded = ['author'];
    protected $table = 'zbw_pages';
    static $rules = [
        'title' => '',
        'author' => 'cid|integer',
        'content' => '',
        'is_official' => 'integer',
        'template_id' => 'integer',
        'route' => '',
        'published' => 'integer',
        'audience_type_id' => 'integer',
        'slug' => ''
    ];

    //relations
    public function menu()
    {
        return $this->belongsToMany('Menu', 'zbw_menus_pages', 'page_id', 'menu_id');
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

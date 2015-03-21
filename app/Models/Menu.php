<?php 

/**
 * Menu
 *
 * @property integer $id
 * @property string $title
 * @property string $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\Page[] $pages
 * @method static \Illuminate\Database\Query\Builder|\Menu whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Menu whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Menu whereLocation($value)
 */
class Menu extends BaseModel
{
    protected $guarded = [''];
    protected $table = 'zbw_menus';
    public $timestamps = false;

    //relations
    public function pages()
    {
        return $this->belongsToMany('Page', 'zbw_menus_pages', 'menu_id', 'page_id');
    }

    public function getUrlTitle()
    {
        return str_replace(' ', '_', strtolower($this->title));
    }

    public function getLocation()
    {
        return json_decode($this->location);
    }
} 

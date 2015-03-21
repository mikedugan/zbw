<?php 

/**
 * Page
 *
 * @property integer $id
 * @property string $title
 * @property integer $author
 * @property string $content
 * @property boolean $is_official
 * @property boolean $template_id
 * @property string $route
 * @property string $deleted_at
 * @property boolean $published
 * @property integer $audience_type_id
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\Menu[] $menu
 * @method static \Illuminate\Database\Query\Builder|\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereIsOfficial($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereRoute($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Page wherePublished($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereAudienceTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Page whereSlug($value)
 * @method static \Page staff()
 * @method static \Page pilots()
 * @method static \Page controllers()
 */
class Page extends BaseModel
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

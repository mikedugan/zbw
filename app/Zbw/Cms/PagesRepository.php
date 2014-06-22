<?php  namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;

class PagesRepository extends EloquentRepository
{
    public $model = '\Page';

    public function update($input)
    {

    }

    public function create($input)
    {

    }

    public static function orphaned()
    {
        return \Page::where('menu_id', null)->get();
    }
} 

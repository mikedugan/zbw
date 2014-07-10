<?php  namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Cms\Contracts\PagesRepositoryInterface;

class PagesRepository extends EloquentRepository implements PagesRepositoryInterface
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

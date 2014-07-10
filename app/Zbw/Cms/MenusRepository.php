<?php  namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Cms\Contracts\MenusRepositoryInterface;

class MenusRepository extends EloquentRepository implements MenusRepositoryInterface
{
    public function create($input)
    {
        $menu = new \Menu();
        $menu->title = $input['title'];
        $menu->location = json_encode($input['location']);
        return $menu->save();
    }

    public function update($input)
    {

    }
} 

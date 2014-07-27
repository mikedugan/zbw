<?php  namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;
use Zbw\Cms\Contracts\MenusRepositoryInterface;

class MenusRepository extends EloquentRepository implements MenusRepositoryInterface
{
    public $model = '\Menu';
    public function create($input)
    {
        $menu = new \Menu();
        $menu->title = $input['title'];
        $menu->location = json_encode($input['location']);
        return $this->checkAndSave($menu);
    }

    public function update($input)
    {
        $menu = $this->make()->get($input['id']);
        $menu->title = $input['title'];
        $menu->location = json_encode($input['location']);
        return $this->checkAndSave($menu);
    }
} 

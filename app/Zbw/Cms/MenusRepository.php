<?php  namespace Zbw\Cms;

use Zbw\Base\EloquentRepository;

class MenusRepository extends EloquentRepository
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

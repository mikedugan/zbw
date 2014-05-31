<?php  namespace Zbw\Cms;

class MenusRepository
{
    public static function all()
    {
        return \Menu::all();
    }

    public static function find($id)
    {
        return \Menu::find($id);
    }

    public static function add($input)
    {
        $menu = new \Menu();
        $menu->title = $input['title'];
        $menu->location = json_encode($input['location']);
        return $menu->save();
    }

    public static function delete($id)
    {
        return \Menu::destroy($id);
    }
} 

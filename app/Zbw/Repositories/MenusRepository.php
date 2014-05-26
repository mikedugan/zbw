<?php  namespace Zbw\Repositories; 

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
        $menu = \Menu::create([
            'title' => $input['title'],
            'location' => $input['location']
        ]);
        return $menu->id ? true : false;
    }

    public static function delete($id)
    {
        return \Menu::destroy($id);
    }
} 

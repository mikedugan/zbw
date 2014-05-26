<?php  namespace Zbw\Repositories; 

class PagesRepository
{
    public static function all()
    {
        return \Page::all();
    }

    public static function find($id)
    {
        return \Page::find($id);
    }

    public static function add($input)
    {
        //TODO implement
    }

    public static function delete($id)
    {
        return \Page::destroy($id);
    }

    public static function orphaned()
    {
        return \Page::where('menu_id', null)->get();
    }
} 

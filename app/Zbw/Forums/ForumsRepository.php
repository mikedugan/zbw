<?php namespace Zbw\Forums;

use Zbw\Base\EloquentRepository;

class ForumsRepository extends EloquentRepository {

    public static function all()
    {
        return \Forum::all();
    }

    public static function get($id)
    {
        return \Forum::find($id);
    }

    public static function delete($id)
    {
        return \Forum::destroy($id);
    }

    public function update($input)
    {
        //TODO implement
        return true;
    }

    public function create($input)
    {
        //TODO implement
        return true;
    }
} 

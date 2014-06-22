<?php  namespace Zbw\Contracts; 

abstract class EloquentRepository {

    public static function all()
    {
        return \class_basename(self)::all();
    }

    public static function get($id)
    {
        return \class_basename(self)::find($id);
    }

    public function delete($id)
    {
        return \class_basename(self)::find($id);
    }

    abstract public static function update();
    abstract public static function create();
}

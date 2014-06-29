<?php  namespace Zbw\Base;

abstract class EloquentRepository {

    protected function make()
    {
        return new $this->model;
    }

    public function all()
    {
        return $this->make()->all();
    }

    public function get($id, $withTrash = true)
    {
        if($withTrash) {
            return $this->make()->withTrashed()->find($id);
        } else {
            return $this->make()->find($id);
        }
    }

    public function delete($id)
    {
        $item = $this->get($id, true);
        if($item->trashed())
        {
            $item->forceDelete();
            return true;
        }

        return $item->destroy($id);
    }

    public function trashed()
    {
        if($this->hasSoftDeletes()) {
            return $this->make()->onlyTrashed()->get();
        }
        else return false;
    }

    public function restore($id)
    {
        if($this->hasSoftDeletes()) {
            return $this->make()->restore($id);
        }
        else return false;
    }

    /**
     * @name hasSoftDeletes
     * @description determines if a model uses SoftDeletingTrait
     * @return bool
     */
    protected function hasSoftDeletes()
    {
        return in_array('SoftDeletingTrait', class_uses($this->model));
    }

    abstract public function update($input);
    abstract public function create($input);
}

<?php  namespace Zbw\Base;

abstract class EloquentRepository {

    protected $errors;

    public function getErrors()
    {
        return $this->errors;
    }

    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }


    public function make()
    {
        return new $this->model;
    }

    public function all()
    {
        return $this->make()->all();
    }

    public function eWith($with)
    {
        return $this->make()->with($with);
    }

    public function with($with, $id = null, $pk = 'id', $pagination = null)
    {
        if($pagination) {
            return $this->make()->with($with)->paginate($pagination);
        } else if($id) {
            return $this->make()->where($pk, $id)->with($with)->firstOrFail();
        }
        return $this->make()->with($with)->get();
    }

    public function get($id, $withTrash = false)
    {
        if($withTrash) {
            return $this->make()->withTrashed()->findOrFail($id);
        } else {
            return $this->make()->findOrFail($id);
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->get($id, true);
        }
        catch (\BadMethodCallException $e) {
            return $this->make()->destroy($id);
        }

        if($item->trashed()) {
            {
                $item->forceDelete();
                return true;
            }
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
        return $this->make()->withTrashed()->findOrFail($id)->restore();
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

    protected function checkAndSave($model)
    {
        if(! $model->save()) {
            $this->setErrors($model->getErrors());
            return false;
        }
        else {
            return true;
        }
    }

    abstract public function update($input);
    abstract public function create($input);
}

<?php  namespace Zbw\Core;

use Illuminate\Database\Eloquent\Model;

/**
 * @package Base
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
abstract class EloquentRepository {

    /**
     * @var array
     */
    protected $errors;

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $errors
     * @return void
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function make()
    {
        return new $this->model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->make()->all();
    }

    /**
     * @param $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function eWith($with)
    {
        return $this->make()->with($with);
    }

    /**
     * @todo refactor so this method isn't doing so much
     *
     * this method returns eager loaded data given a set of relations, id (to return only one model), primary key, and pagination count
     *
     * @param        $with          relations
     * @param null   $id            optional int
     * @param string $pk            primary key
     * @param null   $pagination    optional int
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     */
    public function with($with, $id = null, $pk = 'id', $pagination = null)
    {
        if($pagination) {
            return $this->make()->with($with)->paginate($pagination);
        } else if($id) {
            return $this->make()->where($pk, $id)->with($with)->firstOrFail();
        }
        return $this->make()->with($with)->get();
    }

    /**
     * 
     * @param      $id
     * @param bool $withTrash
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function get($id, $withTrash = false)
    {
        if($withTrash) {
            return $this->make()->withTrashed()->findOrFail($id);
        } else {
            return $this->make()->find($id);
        }
    }

    /**
     * 
     * @param $id
     * @return bool
     */
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

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Collection|bool
     */
    public function trashed()
    {
        if($this->hasSoftDeletes()) {
            return $this->make()->onlyTrashed()->get();
        }
        else return false;
    }

    /**
     * 
     * @param $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->make()->withTrashed()->findOrFail($id)->restore();
    }

    /**
     * @name hasSoftDeletes
     *  determines if a model uses SoftDeletingTrait
     * @return bool
     */
    protected function hasSoftDeletes()
    {
        return in_array('SoftDeletingTrait', class_uses($this->model));
    }

    /**
     * 
     * @param $model
     * @return bool
     */
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

    public function save(Model $model, $check = false)
    {
        if($check) {
            return $this->checkAndSave($model);
        } else {
            return $model->save();
        }
    }

    /**
     * 
     * @param $input
     * @return mixed
     */
    abstract public function update($input);

    /**
     * 
     * @param $input
     * @return mixed
     */
    //abstract public function create($input);
}

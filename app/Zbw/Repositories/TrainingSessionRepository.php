<?php namespace Zbw\Repositories;

use Zbw\Interfaces\EloquentRepositoryInterface;

class TrainingSessionRepository implements EloquentRepositoryInterface {
    /**
     * @param integer $id
     * @return mixed
     */
    static function find($id)
    {
        return \TrainingSession::find($id);
    }

    /**
     * @return EloquentCollection
     */
    static function all()
    {
        return \TrainingSession::all();
    }

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    static function add($input)
    {

    }

    /**
     * @param integer $id
     * @return boolean
     */
    static function delete($id)
    {

    }

}

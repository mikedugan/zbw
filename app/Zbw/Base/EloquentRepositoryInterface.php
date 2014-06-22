<?php namespace Zbw\Contracts;

interface EloquentRepositoryInterface {
    /**
     * @param integer $id
     * @param mixed $relations
     * @return mixed
     */
    static function find($id, $relations);

    /**
     * @return EloquentCollection
     */
    static function all();

    /**
     * @param array $input
     * @return mixed array|boolean
     */
    static function add($input);

    /**
     * @param integer $id
     * @return boolean
     */
    static function delete($id);
} 

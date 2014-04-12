<?php namespace Zbw\Interfaces;

interface EloquentRepositoryInterface {
    /**
     * @param integer $id
     * @return mixed
     */
    static function find($id);

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

<?php namespace Zbw\Cms\Contracts;

interface PagesRepositoryInterface
{
    public function all();

    public function with($with, $id = null, $pk = 'id', $pagination = null);

    public function get($id, $withTrash = false);

    public function delete($id);

    public function trashed();

    public function restore($id);

    public function update($input);

    public function create($input);

    public static function orphaned();
}

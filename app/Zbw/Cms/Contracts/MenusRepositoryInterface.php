<?php


namespace Zbw\Cms\Contracts;

interface MenusRepositoryInterface
{
    public function all();

    public function get($id, $withTrash = false);

    public function delete($id);

    public function create($input);

    public function update($input);
}

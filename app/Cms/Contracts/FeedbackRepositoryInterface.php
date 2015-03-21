<?php


namespace Zbw\Cms\Contracts;

interface FeedbackRepositoryInterface
{
    public function all();

    public function get($id, $withTrash = false);

    public function update($input);

    public function create($input);
}

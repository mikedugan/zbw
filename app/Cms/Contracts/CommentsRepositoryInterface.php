<?php namespace Zbw\Cms\Contracts;

interface CommentsRepositoryInterface
{
    public function add($input);

    public function update($input);

    public function create($input);
}

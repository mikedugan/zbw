<?php namespace Zbw\Users\Contracts;

interface GroupsRepositoryInterface
{
    public function update($input);

    public function create($input);

    public function updateGroup($input);
}

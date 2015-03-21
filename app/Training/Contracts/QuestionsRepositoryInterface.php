<?php


namespace Zbw\Training\Contracts;

interface QuestionsRepositoryInterface
{
    public function create($i);

    public function update($data);

    public function all();
}

<?php namespace Zbw\Users\Contracts;

interface VisitorApplicantRepositoryInterface
{
    public function update($input);
    public function create($input);
}

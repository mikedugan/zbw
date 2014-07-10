<?php namespace Zbw\Training\Contracts;

interface CertificationRepositoryInterface
{
    public function update($input);

    public function create($input);

    public function requestExam($cid, $eid);

    public function assignExam($cid);

    public function all();

    public function with($with, $id = null, $pk = 'id', $pagination = null);

    public function get($id, $withTrash = false);
}

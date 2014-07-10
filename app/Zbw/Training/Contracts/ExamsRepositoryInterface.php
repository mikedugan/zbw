<?php namespace Zbw\Training\Contracts;

interface ExamsRepositoryInterface
{
    public function create($i);

    public function update($input);

    public function get($id, $withTrashed = false);

    public function delete($eid);

    public function completeExam($wrong_q, $wrong_a);

    /**
     * @param boolean training
     *
     * @return string next available exam
     */
    public function availableExams($cid);

    public function lastExam($cid);
}

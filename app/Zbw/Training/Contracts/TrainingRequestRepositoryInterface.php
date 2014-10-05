<?php namespace Zbw\Training\Contracts;

interface TrainingRequestRepositoryInterface
{
    /**
     * @param $input
     * @return mixed
     */
    public function update($input);

    /**
     * Create a new training request
     *
     * @param array $input
     * @return bool
     */
    public function create(array $input);

    /**
     * Staff member accept a training request
     *
     * @param $tsid
     * @param $cid
     * @return bool
     */
    public function accept($tsid, $cid, $input);

    /**
     * Staff member drops previously accepted request
     *
     * @param $tsid
     * @param $cid
     * @return bool
     */
    public function drop($tsid, $cid);

    /**
     * Marks a training request as complete
     *
     * @param $tsid
     * @param $report_id
     * @return bool
     */
    public function complete($tsid, $report_id);

    /**
     * Retrieves a paginated set of training requests
     *
     * @param int $n
     * @return \Illuminate\Pagination\Paginator
     */
    public function indexPaginated($n = 10);

    /**
     * Returns a filtered set of training requests
     * Filters: initials, before, after
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function indexFiltered($input);

    /**
     * Returns a single request with all related resources
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
     */
    public function getWithAll($id);

    /**
     * Returns recent requests with all related resources
     *
     * @param int $n
     * @return mixed
     */
    public function getRecent($n = 10);
}

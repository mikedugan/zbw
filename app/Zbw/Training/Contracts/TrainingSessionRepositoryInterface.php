<?php namespace Zbw\Training\Contracts;

interface TrainingSessionRepositoryInterface
{
    /**
     * @param array $input
     *
     * @return mixed array|boolean
     */
    public function create($input);

    public function update($input);

    /**
     * @param integer number of reports
     *
     * @return EloquentCollection
     */
    public static function recentReports($n);
}

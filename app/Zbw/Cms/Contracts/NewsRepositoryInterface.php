<?php namespace Zbw\Cms\Contracts;

interface NewsRepositoryInterface
{
    public function make();

    public function with($with, $id = null, $pk = 'id', $pagination = null);

    public function trashed();

    public function restore($id);

    public function front($lim);

    public function controllers($lim = null);

    public function pilots($lim = null);

    /** functions */
    public function all();

    public function find($id, $relations = null);

    public function findWithRelations($id);

    public function add($input);

    public function update($input);

    public function delete($id);

    public function staffNews($lim, $direction = 'DESC');

    public function recentNews($num, $direction = 'DESC');

    public function events();

    public function activeEvents();

    public function expiredEvents($lim, $sortBy = 'ends', $direction = 'DESC');

    public function upcomingEvents($lim);

    public function create($input);
}

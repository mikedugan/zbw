<?php namespace Zbw\Core\Repositories; 

use Zbw\Core\EloquentRepository;

class RatingRepository extends EloquentRepository
{
    public $model = '\Rating';

    /**
     * @param $input
     * @return mixed
     */
    public function update($input)
    {
    }
}

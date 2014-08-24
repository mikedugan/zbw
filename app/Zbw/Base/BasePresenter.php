<?php  namespace Zbw\Base; 

use Robbo\Presenter\Presenter;

abstract class BasePresenter extends Presenter
{
    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function createdAgo()
    {
        return $this->created_at->diffForHumans();
    }

    public function updatedAgo()
    {
        return $this->updated_at->diffForHumans();
    }
} 

<?php  namespace Zbw\Training\Presenters; 

use Zbw\Core\BasePresenter;
use Zbw\Core\Helpers;

class TrainingRequestPresenter extends BasePresenter
{
    public function presentCert()
    {
        return Helpers::readableCert($this->certType->id);
    }
} 

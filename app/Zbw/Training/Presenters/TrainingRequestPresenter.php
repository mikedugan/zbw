<?php  namespace Zbw\Training\Presenters; 

use Zbw\Base\BasePresenter;
use Zbw\Base\Helpers;

class TrainingRequestPresenter extends BasePresenter
{
    public function presentCert()
    {
        return Helpers::readableCert($this->certType->id);
    }
} 

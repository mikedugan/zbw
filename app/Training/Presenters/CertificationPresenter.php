<?php  namespace Zbw\Training\Presenters; 

use Zbw\Core\BasePresenter;

class CertificationPresenter extends BasePresenter
{
    public function __construct($object)
    {
        parent::__construct($object);
    }

    public function readable()
    {
        switch($this->id) {
            case '0': return 'Observer'; break;
            case '1': return 'Observer'; break;
            case '2': return "Class C/D Ground"; break;
            case '3': return "Class B Ground (Off Peak)"; break;
            case '4': return "Class B Ground"; break;
            case '5': return "Class C/D Tower"; break;
            case '6': return "Class B Tower (Off Peak)"; break;
            case '7': return "Class B Tower"; break;
            case '8': return "Class C Approach"; break;
            case '9': return "Class B Approach (Off Peak)"; break;
            case '10': return "Class B Approach"; break;
            case '11': return "Center (Off Peak)"; break;
            case '12': return "Center Controller"; break;
            case '13': return 'Instructor'; break;
            case '14': return 'Senior Instructor'; break;
            case '15': return 'Senior Controller'; break;
        }
    }

    public function nextReadable()
    {
        switch ($this->id) {
            case '0':
                return 'Observer';
                break;
            case '1':
                return "Class C/D Ground";
                break;
            case '2':
                return "Class B Ground (Off Peak)";
                break;
            case '3':
                return "Class B Ground";
                break;
            case '4':
                return "Class C/D Tower";
                break;
            case '5':
                return "Class B Tower (Off Peak)";
                break;
            case '6':
                return "Class B Tower";
                break;
            case '7':
                return "Class C Approach";
                break;
            case '8':
                return "Class B Approach (Off Peak)";
                break;
            case '9':
                return "Class B Approach";
                break;
            case '10':
                return "Center (Off Peak)";
                break;
            case '11':
                return "Center Controller";
                break;
            case '12':
                return 'Instructor';
                break;
            case '13':
                return 'Senior Instructor';
                break;
            case '14':
                return 'Senior Controller';
                break;
        }
    }
} 

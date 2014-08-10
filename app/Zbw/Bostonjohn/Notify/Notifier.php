<?php  namespace Zbw\Bostonjohn\Notify; 

use Zbw\Users\Contracts\UserRepositoryInterface;

abstract class Notifier {

    protected $users;
    protected $view;
    protected $view_data;
    protected $from;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
        $this->from = \Sentry::findUserById(100);
    }

    protected function setView($view)
    {
        $class = $this->get_class_name();
        if($class === 'Mail') {
            $this->view = 'zbw.emails.'.$view;
        } else if ($class === 'Message') {
            $this->view = 'zbw.messages.'.$view;
        }
    }

    protected function setViewData($data)
    {
        $this->view_data = $data;
    }

    private function get_class_name()
    {
        $class = explode('\\', get_class($this));
        return $class[count($class) - 1];
    }
} 

<?php  namespace Zbw\Notifier; 

use Zbw\Users\Contracts\UserRepositoryInterface;

/**
 * @package Bostonjohn
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.8b
 */
abstract class Notifier {

    /**
     * @var \Zbw\Users\UserRepository
     */
    protected $users;
    /**
     * @var string
     */
    protected $view;
    /**
     * @var array
     */
    protected $view_data;
    /**
     * @var \User
     */
    protected $from;

    /**
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
        //$this->from = \Sentry::findUserById(100); //100 == Bostonjohn
    }

    /**
     * @param $view
     * @return void
     */
    protected function setView($view)
    {
        $class = $this->get_class_name();
        if($class === 'Mail') {
            $this->view = 'zbw.emails.'.$view;
        } else if ($class === 'Message') {
            $this->view = 'zbw.messages.'.$view;
        }
    }

    /**
     * @param $data
     * @return void
     */
    protected function setViewData($data)
    {
        $this->view_data = $data;
    }

    /**
     * @return mixed
     */
    private function get_class_name()
    {
        $class = explode('\\', get_class($this));
        return $class[count($class) - 1];
    }
} 

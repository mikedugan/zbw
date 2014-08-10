<?php  namespace Zbw\Bostonjohn\Queues;

/**
 * @package Zbw\Bostonjohn\Queues
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class QueueDispatcher {

    /**
     * @param string $method
     * @param string $args classMemberFunction
     * @return void
     */
    public function __call($method, $args)
    {
        //split the method name from the class
        $method = preg_split('/(?=[A-Z])/', lcfirst($method));

        //the class
        $service = \App::make('Zbw\Bostonjohn\Queues\\'. ucfirst($method[0]));

        //convert the split method to a proper class method
        $method = lcfirst(implode(array_slice($method, 1, count($method)), ''));

        //call it
        $service->{$method}($args[0], $args[1]);
    }
} 

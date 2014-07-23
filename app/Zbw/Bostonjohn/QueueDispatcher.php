<?php  namespace Zbw\Bostonjohn;

class QueueDispatcher {

    public function __call($method, $args)
    {
        $method = preg_split('/(?=[A-Z])/', lcfirst($method));
        $service = \App::make('Zbw\Bostonjohn\Queues\\'. ucfirst($method[0]));
        $method = lcfirst(implode(array_slice($method, 1, count($method)), ''));
        $service->{$method}($args[0], $args[1]);
    }
} 

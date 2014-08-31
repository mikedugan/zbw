<?php  namespace Zbw\Core; 

use Laracasts\Commander\Exception;
use Laracasts\Commander\HandlerNotRegisteredException;

class CommandTranslator implements \Laracasts\Commander\CommandTranslator
{
    /**
     * Translate a command to its handler counterpart
     * @param $command
     * @return mixed
     * @throws HandlerNotRegisteredException
     */
    public function toCommandHandler($command)
    {
        $handler = $this->assembleNamespace(get_class($command), 'Handler');
        if(! class_exists($handler)) {
            $message = "Command handler [$handler] does not exist.";
            throw new HandlerNotRegisteredException($message);
        }

        return $handler;
    }

    /**
     * Translate a command to its validator counterpart
     * @param $command
     * @return mixed
     */
    public function toValidator($command)
    {
        return $this->assembleNamespace(get_class($command), 'Validator');
    }

    /**
     * Converts a command object class string to string for Validators and Handlers
     * ie: Dsp\Users\Commands\RegisterUserCommand -> Dsp\Users\Handlers\RegisterUserHandler
     * ie: Dsp\Users\Commands\RegisterUserCommand -> Dsp\Users\Validators\RegisterUserValidator
     *
     * @param $str
     * @return string
     */
    private function assembleNamespace($str, $type)
    {
        $parts = explode('\\', $str);
        //the actual class name
        $class = str_replace('Command', $type, array_pop($parts));
        //the class's namespace
        $ns = str_replace('Commands', $type.'s', array_pop($parts));
        //reassemble and return
        return implode('\\', $parts).'\\'.$ns.'\\'.$class;
    }
}

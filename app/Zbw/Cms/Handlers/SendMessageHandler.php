<?php  namespace Zbw\Cms\Handlers; 

use Zbw\Cms\Commands\SendMessageCommand;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

class SendMessageHandler
{
    private $messages;

    public function __construct(MessagesRepositoryInterface $messages)
    {
        $this->messages = $messages;
    }

    public function handle(SendMessageCommand $command)
    {
        return $this->messages->add($command->input);
    }
} 

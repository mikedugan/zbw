<?php  namespace Zbw\Cms\Handlers; 

use Zbw\Cms\Commands\ReplyToMessageCommand;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

class ReplyToMessageHandler
{
    private $messages;

    public function __construct(MessagesRepositoryInterface $messages)
    {
        $this->messages = $messages;
    }

    public function handle(ReplyToMessageCommand $command)
    {
        if ($command->input['cc'] !== '') {
            $this->messages->cc($command->input, $command->input['cc'], $command->message_id);
        }

        return $this->messages->reply($command->input, $command->message_id);
    }
} 

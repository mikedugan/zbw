<?php  namespace Zbw\Bostonjohn\Queues; 

use Illuminate\Queue\Jobs\Job;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Bostonjohn\Notifier;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

class Training {

    private $users;
    private $notifier;
    private $messages;

    public function __construct(UserRepositoryInterface $users, Notifier $notifier, MessagesRepositoryInterface $messages)
    {
        $this->users = $users;
        $this->notifier = $notifier;
        $this->messages = $messages;
    }

    public function newRequest(Job $job, $data)
    {
        $data = \TrainingRequest::find($data['id']);
        $notify = \Zbw\Users\UserRepository::canTrain($data->cert_id);
        $student = \User::find($data->cid);
        $message = "
        Hello _USER_,
        This is an automated message to inform you that a ZBW controller has requested training.

        Controller: $student->initials
        Training Requested: ". \Zbw\Base\Helpers::readableCert($data->cert_id) . "
        Requested Start: " . $data->start->toDayDateTimeString() . "
        Requested End: " . $data->end->toDayDateTimeString() . "

        Replying to this message will result in a .kill
        MOCHa HAGoTDI,
        Boston John
        ";
        foreach($notify as $cid) {
            $user = $this->users->get($cid);
            if($user->wants('email', 'training_request')) {
                $this->notifier->trainingRequestEmail(['cid' => $data->cid, 'to' => $user->cid, 'request' => $data]);
            }
            if($user->wants('message', 'training_request')) {
                $this->messages->create([
                      'subject' => 'ZBW Training Request',
                      'message' => str_replace('_USER_', $user->initials, $message)
                  ]);
            }
        }
        $job->delete();
    }

} 

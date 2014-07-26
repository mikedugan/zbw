<?php  namespace Zbw\Bostonjohn\Queues; 

use Illuminate\Queue\Jobs\Job;
use Zbw\Base\Helpers;
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
        $vdata = [
            'student' => $student,
            'cert' => Helpers::readableCert($data->cert_id),
            'start' => $data->start->toDayDateTimeString(),
            'end' => $data->end->toDayDateTimeString()
        ];
        $message = \View::make('zbw.messages.s_training_request', $vdata)->render();
        foreach($notify as $cid) {
            $user = $this->users->get($cid);
            if($user->wants('email', 'training_request')) {
                $this->notifier->trainingRequestEmail(['cid' => $data->cid, 'to' => $user->cid, 'request' => $data]);
            }
            if($user->wants('message', 'training_request')) {
                $this->messages->create([
                      'subject' => 'ZBW Training Request',
                      'to' => $user->initials,
                      'message' => str_replace('_USER_', $user->initials, $message)
                  ]);
            }
        }
        $job->delete();
    }

} 

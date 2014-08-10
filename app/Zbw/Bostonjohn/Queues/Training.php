<?php  namespace Zbw\Bostonjohn\Queues; 

use Illuminate\Queue\Jobs\Job;
use Zbw\Base\Helpers;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Bostonjohn\Notify\Mail;
use Zbw\Cms\Contracts\MessagesRepositoryInterface;

/**
 * @package Zbw\Bostonjohn\Queues
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.b
 */
class Training {

    /**
     * UserRepositoryInterface
     */
    private $users;
    /**
     * Mail
     */
    private $notifier;
    /**
     * MessagesRepositoryInterface
     */
    private $messages;

    /**
     * @param UserRepositoryInterface     $users
     * @param Mail                    $notifier
     * @param MessagesRepositoryInterface $messages
     */
    public function __construct(UserRepositoryInterface $users, Mail $notifier, MessagesRepositoryInterface $messages)
    {
        $this->users = $users;
        $this->notifier = $notifier;
        $this->messages = $messages;
    }

    /**
     *  sends notifications to training staff for new training requests
     *
     * @param Job      $job
     * @param array    $data
     *
     * @return void
     */
    public function newRequest(Job $job, $data)
    {
        //get the training request
        $data = \TrainingRequest::find($data['id']);

        //get a list of who can train this student
        $notify = UserRepository::canTrain($data->cert_id);
        $student = $this->users->get($data->cid); //the student
        //setup the data to be passed to the private message view
        $vdata = [
            'student' => $student,
            'cert' => Helpers::readableCert($data->cert_id),
            'start' => $data->start->toDayDateTimeString(),
            'end' => $data->end->toDayDateTimeString()
        ];
        //render the private message view
        $message = \View::make('zbw.messages.s_training_request', $vdata)->render();
        foreach($notify as $cid) {
            $user = $this->users->get($cid);
            //email the training staff member if they've elected to receive email notifications
            if($user->wants('email', 'training_request')) {
                $this->notifier->trainingRequestEmail(['cid' => $data->cid, 'to' => $user->cid, 'request' => $data]);
            }
            //send private message if they want those
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

    /**
     *  sends notifications when a training session is accepted
     *
     * @param Job $job
     * @param     $data
     * @return void
     */
    public function acceptRequest(Job $job, $data)
    {
        $data = \TrainingRequest::find($data['id']);

        //this notification will go out only to the student
        //let's set up the data
        $student = \User::find($data->cid);
        $staff = \User::find($data->sid);
        $vdata = [
            'student' => $student,
            'staff' => $staff,
            'cert' => Helpers::readableCert($data->cert_id),
            'start' => $data->start->toDayDateTimeString(),
            'end' => $data->end->toDayDateTimeString()
        ];

        //render the message
        $message = \View::make('zbw.messages.training_request_accepted', $vdata)->render();

        //check if the student wants email notifications
        if($student->wants('email', 'training_accepted')) {
            //send email
            $this->notifier->trainingRequestAcceptedEmail(['cid' => $student->cid, 'to' => $student->cid, 'request' => $data]);
        }
        //check if student wants pm notifications
        if($student->wants('message', 'training_accepted')) {
            //send the pm
            $this->messages->create([
                  'subject' => 'Training Request Accepted',
                  'to' => $student->initials,
                  'message' => str_replace('_USER_', $student->initials, $message)
              ]);
        }
        $job->delete();
    }

    /**
     *  sends notifications if a training sessions is dropped
     *
     * @param Job $job
     * @param     $data
     *
     * @return void
     */
    public function dropRequest(Job $job, $data)
    {
        $data = \TrainingRequest::find($data['id']);

        //this notification will go out only to the student
        $student = \User::find($data->cid);
        $staff = \User::find($data->sid);
        $vdata = [
          'student' => $student,
          'staff' => $staff,
          'cert' => Helpers::readableCert($data->cert_id),
          'start' => $data->start->toDayDateTimeString(),
          'end' => $data->end->toDayDateTimeString()
        ];

        //render the view
        $message = \View::make('zbw.messages.training_request_dropped', $vdata)->render();

        //check if user wants email notifications
        if($student->wants('email', 'training_cancelled')) {
            //send email
            $this->notifier->trainingRequestDroppedEmail(['cid' => $student->cid, 'to' => $student->cid, 'request' => $data]);
        }
        //check if user wants pm notifications
        if($student->wants('message', 'training_cancelled')) {
            //send pm
            $this->messages->create([
                'subject' => 'Training Request Dropped',
                'to' => $student->initials,
                'message' => str_replace('_USER_', $student->initials, $message)
              ]);
        }
        $job->delete();
    }

} 

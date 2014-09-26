<?php  namespace Zbw\Notifier;

use Illuminate\Mail\Mailer;
use Zbw\Notifier\Contracts\MailInterface;
use Zbw\Core\Helpers;
use Zbw\Users\Contracts\UserRepositoryInterface;

/**
 * @package Bostonjohn
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.8b
 */
class Mail extends Notifier implements MailInterface
{
    private $mailer;
    public function __construct(UserRepositoryInterface $users, Mailer $mailer)
    {
        parent::__construct($users);
        $this->mailer = $mailer;
    }

    /**
     *  wrapper for Illuminate\Mail\Mailer::send
     * @param $to_email
     * @param $to_name
     * @param $subject
     * @return void
     */
    private function send($to_email, $to_name, $subject)
    {
        $this->mailer->send($this->view, $this->view_data, function($message) use($to_email, $to_name, $subject) {
            $this->buildMessage($message, $to_name, $to_email, $subject);
        });
    }

    /**
     *  builds message to/from/subject
     * @param $message
     * @param $to_name
     * @param $to_email
     * @param $subject
     * @return mixed
     */
    private function buildMessage($message, $to_name, $to_email, $subject)
    {
        $message->from($this->from->email, $this->from->name);
        $message->to('mike@mjdugan.com', $to_name);
        $message->subject($subject);
        return $message;
    }

    /**
     * @param $cid
     * @return void
     */
    public function newUserEmail($cid)
    {
        $user = $this->users->get($cid);
        $this->setView('new-user');
        $this->setViewData(['user' => $user]);
        $this->send($user->email, $user->username, 'Welcome to ZBW');
    }

    /**
     * @param $cid
     * @return void
     */
    public function staffWelcomeEmail($cid)
    {
        $to = $this->users->get($cid);
        $this->setView('welcome-staff');
        $this->setViewData([
            'user' => $to
        ]);
        $this->send($to->email, $to->username, 'Welcome to the ZBW Staff');
    }

    /**
     * @param $data
     * @return void
     */
    public function trainingRequestEmail($data)
    {
        $this->setView('training-request');
        $this->setViewData([
            'user' => $this->users->get($data['cid']),
            'to' => $this->users->get($data['to']),
            'request' => $data['request']
        ]);
        $this->send($this->view_data['to']->email, $this->view_data['to']->username, 'ZBW Training Request');
    }

    /**
     * @param $data
     * @return void
     */
    public function trainingRequestAcceptedEmail($data)
    {
        $this->setView('training_request_accepted');
        $this->setViewData([
          'to' => $this->users->get($data['to']),
          'request' => $data['request'],
          'staff' => $this->users->get($data['request']->sid),
          'cert' => Helpers::readableCert($data['request']->cert_id),
          'start' => $data['request']->start->toDayDateTimeString(),
          'end' => $data['request']->end->toDayDateTimeString()
        ]);
        $this->send($this->view_data['to']->email, $this->view_data['to']->username, 'ZBW Training Request');
    }

    /**
     * @param $data
     * @return void
     */
    public function trainingRequestDroppedEmail($data)
    {
        $this->setView('training_request_dropped');
        $this->setViewData([
          'to' => $this->users->get($data['to']),
          'request' => $data['request'],
          'cert' => Helpers::readableCert($data['request']->cert_id),
          'start' => $data['request']->start->toDayDateTimeString(),
          'end' => $data['request']->end->toDayDateTimeString()
        ]);
        $this->send($this->view_data['to']->email, $this->view_data['to']->username, 'ZBW Training Request');
    }

    /**
     * @param $data
     * @return void
     */
    public function visitorRequestEmail($data)
    {
        $this->setView('visitor_request');
        $to = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('DATM'));
        $this->setViewData([
            'to' => $to[0],
            'firstname' => $data['fname'],
            'lastname' => $data['lname'],
            'rating' => $data['rating'],
            'home' => $data['home'],
            'email' => $data['email'],
            'body' => $data['message'],
            'cid' => $data['cid']
        ]);
        $this->send($this->view_data['to']->email, $this->view_data['to']->username, 'ZBW Visiting Controller Request');
    }

    /**
     * @param $data
     * @return void
     */
    public function staffContactEmail($data)
    {
        $to = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName($data['to']))[0];

        $this->setView('staff_contact');
        $this->setViewData([
            'to' => $to,
            'from' => $data['email'],
            'subject' => $data['subject'],
            'content' => $data['message']
        ]);
        $this->send($this->view_data['to']->email, $this->view_data['to']->username, 'ZBW Staff Contact');
    }

    /**
     * @param $data
     * @return void
     */
    public function acceptVisitorEmail($data)
    {
        $this->setView('new_visitor');
        $this->setViewData([
          'user' => $data
        ]);
        $this->send($data->email, $data->username, 'Welcome to ZBW');
    }

    /**
     * @param $data
     * @return void
     */
    public function denyVisitorEmail($data)
    {
        $visitor = \VisitorApplicant::where('cid', $data[0])->firstOrFail();
        $content = $data[1];

        $this->setView('deny_visitor');
        $this->setViewData([
          'visitor' => $visitor,
          'content' => $content
        ]);
        $this->send($visitor->email, $visitor->username, 'vZBW Visitor Application');
    }

    /**
     * @param $cid
     * @return void
     */
    public function vatusaExamRequestEmail($cid)
    {
        $student = $this->users->get($cid);
        $to = \Sentry::findAllUsersInGroup(\Sentry::findGroupByName('Instructors'));

        $this->setView('vatusa_exam_request');
        $this->setViewData(['student' => $student]);
        foreach($to as $staff) {
            $this->send($staff->email, $staff->username, 'VATUSA Exam Request');
        }
    }

    public function adoptUserEmail($student, $staff, $subject, $message, $datetime)
    {
        $student = $this->users->get($student);
        $staff = $this->users->get($staff);

        $this->setView('adopt_user');
        $this->setViewData([
            'student' => $student,
            'staff' => $staff,
            'content' => $message,
            'date' => $datetime,
            'subject' => $subject
        ]);
        $this->send($student->email, $student->username, $subject);
    }

    public function newForumAccountEmail($cid, $password)
    {
        $user = $this->users->get($cid);
        $this->setView('new_forum_account');
        $this->setViewData([
            'user' => $user,
            'password' => $password
        ]);
        $this->send($user->email, $user->username, 'Your vZBW Forum Account');
    }

    public function newPmEmail($message)
    {
        $message = \Message::find($message['id']);
        $user = $this->users->get($message->cid);
        if(! $user->wants('email', 'private_message')) return;
        $this->setView('new_pm');
        $this->setViewData([
            'user' => $user,
            'pm' => $message
        ]);
        $this->send($user->email, $user->username, 'ZBW Private Message from '.$message->sender->initials);
    }

    public function newExamCommentEmail($comment, array $notify)
    {
        $comment = \Comment::find($comment['id']);
        foreach($notify as $user)
        {
            if($user == $comment->author) { return; }
            $u = $this->users->get($user);
            if(! $u->wants('email', 'exam_comment')) return;
            $this->setView('new_exam_comment');
            $this->setViewData([
                'user' => $u,
                'comment' => $comment
            ]);
            $this->send($u->email, $u->username, 'ZBW - New Exam Comment');
        }

        $u = $this->users->get($comment->exam->cid);
        if(! $u->wants('email', 'exam_comment')) return;
        $this->setView('new_exam_comment');
        $this->setViewData([
            'user' => $u,
            'comment' => $comment
        ]);
        $this->send($u->email, $u->username, 'ZBW - New Exam Comment');
    }
} 

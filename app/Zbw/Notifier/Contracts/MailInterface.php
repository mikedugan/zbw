<?php
namespace Zbw\Notifier\Contracts;

interface MailInterface
{
    public function newUserEmail($cid);

    public function staffWelcomeEmail($cid);

    public function trainingRequestEmail($data);

    public function trainingRequestAcceptedEmail($data);

    public function trainingRequestDroppedEmail($data);

    public function visitorRequestEmail($data);

    public function staffContactEmail($data);

    public function acceptVisitorEmail($data);

    public function denyVisitorEmail($data);

    public function vatusaExamRequestEmail($cid);
}

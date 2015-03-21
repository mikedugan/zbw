<?php  namespace Zbw\Events;

/**
 * @package Zbw\Events
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class TrainingEventHandler {

    public function subscribe($events)
    {
        $list = [
        'training.acceptRequest',
        'training.newRequest',
        'training.requestExam',
        'training.finishExam',
        'training.assignExam',
        'training.completeExamReview',
        'training.startExamReview'
        ];

        foreach($list as $event)
        {
            $method = 'TrainingEventHandler@'.explode('.', $event)[1];
            $events->listen($event, $method);
        }
    }

    public function acceptRequest($event)
    {

    }

    public function newRequest($event)
    {

    }

    public function requestExam($event)
    {

    }

    public function finishExam($event)
    {

    }

    public function assignExam($event)
    {

    }

    public function completeExamReview($event)
    {

    }

    public function startExamReview($event)
    {

    }
} 

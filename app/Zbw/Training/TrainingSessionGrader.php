<?php  namespace Zbw\Training;

use Carbon\Carbon;

class TrainingSessionGrader
{
    private $raw;
    private $reviews;
    private $performance;
    private $markups;
    private $markdowns;
    private $staff_comment;
    private $student_comment;
    private $conditions;
    private $times;
    private $score;
    private $facility;
    private $type;
    private $pos_points;
    private $neg_points;
    private $modifier;

    public function __construct(Array $input)
    {
        $this->raw = $input;
        $this->parseInput();
    }

    public function fileReport()
    {
        return $this->createTrainingReport();
    }

    private function createTrainingReport()
    {
        $report = new \TrainingReport();
        $session = new \TrainingSession();
        $session->sid = \Sentry::getUser()->cid;
        $session->cid = $this->raw['student'];
        $session->session_date = Carbon::now();
        $session->weather_id = $this->conditions['weather'];
        $session->complexity_id = $this->conditions['complexity'];
        $session->workload_id = $this->conditions['workload'];
        $session->staff_comment = $this->staff_comment;
        $session->student_comment = $this->student_comment;
        $session->is_ots = $this->ots;
        $session->facility_id = $this->facility;
        $session->brief_time = ($this->times['brief']+$this->times['debrief'])/1000/60;
        $session->position_time = $this->times['live']/1000/60;
        $session->is_live = $this->type == 3 ? 1 : 0;
        $session->training_type_id = $this->type;
        $session->save();

        foreach($this->performance as $key => $value) {
            $report->{$key} = $value;
        }

        $report->reviewed = json_encode($this->reviews);
        $report->training_session_id = $session->id;
        $report->markups = json_encode($this->markups);
        $report->markdown = json_encode($this->markdowns);
        $report->modifier = is_null($this->modifier) ? 0 : $this->modifier;
        $report->positive_points = $this->pos_points;
        $report->negative_points = $this->neg_points;
        $report->ots = $this->ots;
        $report->save();
        return $session;
    }

    private function parseInput()
    {
        $this->parsePerformanceAndReviews();
        $this->parseConditions();
        $this->parseMarkups();
        $this->parseMarkdowns();
        $this->parseComments();
        $this->parseTimers();
        $this->parseFinalScore();
    }

    private function parsePerformanceAndReviews()
    {
        $subjects = ['brief','runway','weather','coordination','flow','identity',
        'separation','pointouts','airspace','loa','phraseology','priority'];

        //parse the json string from hidden input fields
        $reviews = json_decode($this->raw['final_reviews']);
        $performance = json_decode($this->raw['final_performance']);
        //loop through the subjects
        foreach($subjects as $subject) {
            //save the score
            $this->performance[$subject] = $performance->{$subject};
            if(!empty($reviews->{$subject})) {
                //if subject was reviewed, save it
                $this->reviews[$subject] = $reviews->{$subject};
            }
        }
    }

    private function parseFinalScore()
    {
        $this->score = $this->raw['final_score'];
        if(! isset($this->raw['ots'])) { $this->ots = -1; }
        else if($this->raw['ots'] == 'f') { $this->ots = 0; }
        else if ($this->raw['ots'] == 'p') { $this->ots = 1; }
        else $this->ots = -1;
    }

    private function parseConditions()
    {
        $this->facility = $this->raw['facility'];
        $this->type = $this->raw['training_type'];
        $this->conditions['weather'] = $this->raw['cond-weather'] +1;
        $this->conditions['complexity'] = $this->raw['cond-complexity'] +1;
        $this->conditions['workload'] = $this->raw['cond-traffic'] +1;
    }

    private function parseMarkups()
    {
        foreach(json_decode($this->raw['final_markups'], TRUE) as $title => $number) {
            $this->markups[$title] = [$title, $number];
        }
        $this->pos_points = $this->raw['pos_points'];
    }

    private function parseMarkdowns()
    {
        foreach(json_decode($this->raw['final_markdowns'], TRUE) as $title => $number) {
            $this->markdowns[$title] = [$title, $number];
        }
        $this->neg_points = $this->raw['neg_points'];
    }

    private function parseComments()
    {
        $this->staff_comment = $this->raw['comment-db'];
        $this->student_comment = $this->raw['comment-student'];
    }

    private function parseTimers()
    {
        $timers = json_decode($this->raw['final_timers']);
        $this->times['brief'] = $timers->live - $timers->start;
        $this->times['live'] = $timers->debrief - $timers->start;
        $this->times['debrief'] = $timers->complete - $timers->debrief;
        $this->times['total'] = $this->times['brief'] + $this->times['live'] + $this->times['debrief'];
    }
}

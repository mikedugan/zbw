<?php  namespace Zbw\Users;


use Zbw\Training\Contracts\ExamsRepositoryInterface;
use Zbw\Users\Contracts\UserRepositoryInterface;

class UserPromoter {

    private $exams;
    private $users;

    /**
     * @var \User
     */
    private $student;

    public function __construct(UserRepositoryInterface $users, ExamsRepositoryInterface $exams)
    {
        $this->users = $users;
        $this->exams = $exams;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student)
    {
        $this->student = \Sentry::findUserById($student);
    }


    public function promote($cid)
    {
        $this->setStudent($cid);
        $last_exam = $this->exams->lastExam($this->student->cid);

    }

    private function isOtsPromotion($exam)
    {
        /**  when do ots promos happen?
             -- promotion from off-peak to on-peak.
         *   -- this is the only time there would be an OTS without an accompanying exam
         */
    }

    private function isVatusaPrpmotion($exam)
    {
        /**
         * what is the significance of the VATUSA exam?
         * -- this is required to begin controlling with any new rating
         */
        return $exam->total_questions === 1;
    }
} 

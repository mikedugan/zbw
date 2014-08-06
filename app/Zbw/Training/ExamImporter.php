<?php  namespace Zbw\Training; 

class ExamImporter {
    private $files;

    const EXAM_ID = 1;
    const QUESTION = 5;
    const ANSWER = 6;
    const ALT1 = 7;
    const ALT2 = 8;
    const ALT3 = 9;

    const SOP = '162';
    const C_S1 = '163';
    const C_S2 = '164';
    const C_S3 = '166';
    const B_S1 = '228';
    const B_S2 = '165';
    const B_S3 = '167';
    const C_C1 = '168';


    public function __construct()
    {
        $this->files = ['b_s1', 'b_s2', 'b_s3', 'c_c1', 'c_s1', 'c_s2', 'c_s3', 'sop'];
    }

    public function import()
    {
        $questions = 0;
        foreach($this->files as $file) {
            $open = $file.'.csv';
            $fh = fopen('http://localhost:8000/exams/'.$open, 'r');
            while($line = fgetcsv($fh)) {
                $question = $line[self::QUESTION];
                $answera = $line[self::ANSWER];
                $answerb = $line[self::ALT1];
                $answerc = $line[self::ALT2];
                $answerd = $line[self::ALT3];
                $cert = $this->getCertId($line);
                $eq = new \ExamQuestion();
                $eq->cert_type_id = $cert;
                $eq->question = $question;
                $eq->answer_a = $answera;
                $eq->answer_b = $answerb;
                $eq->answer_c = $answerc;
                $eq->answer_d = $answerd;
                $eq->correct = 1;
                $eq->save();
                $questions++;
            }
        }
        return $questions;
    }

    /**
     * @name  getCertId
     * @param $line
     * @return void
     */
    private function getCertId($line)
    {
        switch ($line[self::EXAM_ID]) {
            case self::SOP:
                return 1;
                break;
            case self::C_S1:
                return 2;
                break;
            case self::C_S2:
                return 5;
                break;
            case self::C_S3:
                return 8;
                break;
            case self::C_C1:
                return 11;
                break;
            case self::B_S1:
                return 3;
                break;
            case self::B_S2:
                return 6;
                break;
            case self::B_S3:
                return 9;
                break;
        }
}
} 

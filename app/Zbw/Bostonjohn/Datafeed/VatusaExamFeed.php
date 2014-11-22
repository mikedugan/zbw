<?php  namespace Zbw\Bostonjohn\Datafeed; 

use Curl\Curl;

class VatusaExamFeed
{
    private $examUrl;
    private $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
        $url = \Config::get('zbw.vatusa.exams');
        $this->examUrl = str_replace(
            ['VATID', 'VATKEY'],
            [getenv('vatid'), getenv('vatkey')],
            $url);
    }

    /**
     * @param $cid
     * @return VatusaExam[]
     */
    public function getByCid($cid)
    {
        $this->examUrl = str_replace('CCID', $cid, $this->examUrl);
        $buf = [];
        foreach($this->getExamsXmlCollection() as $test) {
            $buf[] = $this->buildExam($test);
        }

        return $buf;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getExamsXmlCollection()
    {
        $this->curl->get($this->examUrl);
        $xml = $this->curl->response;
        return simplexml_load_string($xml)->test;
    }

    /**
     * @param $test
     * @return array
     */
    private function buildExam($test)
    {
        $exam['cid'] = $test->cid;
        $exam['exam'] = $test->exam;
        $exam['exam_date'] = $test->exam_date;
        $exam['exam_score'] = $test->exam_score;
        return $exam;
    }
}

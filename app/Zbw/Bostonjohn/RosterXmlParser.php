<?php  namespace Zbw\Bostonjohn;

use Curl\Curl;
use Zbw\Users\UserRepositoryInterface;

class RosterXmlParser
{

    private $roster_url;
    private $curl;

    public function __construct(UserRepositoryInterface $users, Curl $curl)
    {
        $this->users = $users;
        $this->curl = $curl;
        $this->roster_url = \Config::get('zbw.vatusa.roster');
        $this->roster_url = str_replace(
          ['VATID', 'VATKEY'],
          [$_ENV['vatid'], $_ENV['vatkey']],
          $this->roster_url
        );
    }

    public function updateRoster()
    {
        $roster = $this->getRosterXmlObject();
        $counter = 0;
        foreach($roster as $member) {
            if($this->users->exists($member->cid)) { continue; }
            $this->users->add($member->fname, $member->lname, $member->email, 'ZBW',
                              $member->cid, $member->rating, false);
            $counter++;
        }
        return $counter;
    }

    private function getRosterXmlObject()
    {
        $this->curl->get($this->roster_url);
        return simplexml_load_string($this->curl->response);
    }
} 

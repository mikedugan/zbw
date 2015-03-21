<?php  namespace Zbw\Bostonjohn\Roster;

use Curl\Curl;
use Zbw\Bostonjohn\Roster\Contracts\RosterUpdater;
use Zbw\Users\Contracts\UserRepositoryInterface;
use Zbw\Training\ExamRecord;

/**
 * @package Bostonjohn
 * @author Mike Dugan <mike@mjdugan.com>
 * @since 2.0.0b
 */
class VatusaRosterUpdater implements RosterUpdater
{

    /**
     * @var string
     */
    private $roster_url;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var \Zbw\Users\UserRepository
     */
    private $users;

    /**
     * @param UserRepositoryInterface $users
     * @param Curl                    $curl
     */
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

    /**
     * 
     * @return int
     */
    public function update()
    {
        $roster = $this->getRosterXmlObject();
        $counter = 0;
        foreach($roster as $member) {
            if($this->users->exists($member->cid)) { continue; }
            $this->users->add($member->fname, $member->lname, $member->email, 'ZBW',
                              $member->cid, $member->rating, false);
            $examRecord = new ExamRecord();
            $examRecord->cid = $member->cid;
            $examRecord->save();
            \Queue::push('Zbw\Queues\QueueDispatcher@usersNewUser', $member);
            $counter++;
        }
        return $counter;
    }

    /**
     * 
     * @return \SimpleXMLElement
     */
    private function getRosterXmlObject()
    {
        $this->curl->get($this->roster_url);
        return simplexml_load_string($this->curl->response);
    }
} 

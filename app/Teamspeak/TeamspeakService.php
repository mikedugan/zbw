<?php namespace Zbw\Teamspeak; 

use TeamSpeak3\TeamSpeak3;
use TeamSpeak3\Node\Client;
use TeamSpeak3\Ts3Exception;

class TeamspeakService
{
    /** @var \TeamSpeak3\Node\Server */
    private $ts3;

    public function __construct()
    {
        if(\Session::has('ts_connection')) {
            $this->ts3 = unserialize(\Session::get('ts_connection'));
        } else {
            $this->ts3 = TeamSpeak3::factory("serverquery://{$_ENV['ts_user']}:{$_ENV['ts_pass']}@192.99.183.143:10011/?server_port=9987");
            $this->ts3->selfUpdate(['client_nickname' => 'Boston John']);
        }
    }

    public function __destruct()
    {
        \Session::forget('ts_connection');
        \Session::put('ts_connection', serialize($this->ts3));
    }


    /**
     * Returns list of connected Teamspeak clients
     *
     * @return array
     */
    public function online()
    {
        return $this->ts3->clientList();
    }

    public function kick($client, $message)
    {
        if(! is_object($client)) {
            $client = $this->getTsUser($client);
        }
        return $this->ts3->clientKick($client->getId(), TeamSpeak3::KICK_SERVER, $message);
    }

    public function message($client, $message)
    {
        if(! is_object($client)) {
            $client = $this->getTsUser($client);
        }
        /** @var $client Client */
        return $client->message($message);
    }

    public function getZbwUser($cid)
    {
        $online = $this->online();

        $ret = [];

        foreach($online as $tsUser) {
            /* @var $tsUser Client */
            try {
                $info = $tsUser->infoDb();
            } catch (Ts3Exception $e) {
                continue;
            }

            $uid = $info['client_unique_identifier']->toString();
            $key = \TsKey::where('uid', $uid)->first();
            if($key && $key->user->cid === $cid) { return $key->user; }
        }
    }

    public function getTsUser($cid)
    {
        $online = $this->online();

        $ret = [];

        foreach($online as $tsUser) {
            /* @var $tsUser Client */
            try {
                $info = $tsUser->infoDb();
            } catch (Ts3Exception $e) {
                continue;
            }

            $uid = $info['client_unique_identifier']->toString();
            $key = \TsKey::where('uid', $uid)->first();
            if($key && $key->user->cid == $cid) { return $tsUser; }
        }
    }

    public function connectedZbwUsers()
    {
        $online = $this->online();
        $ret = [];

        foreach($online as $tsUser) {
            /* @var $tsUser Client */
            try {
                $info = $tsUser->infoDb();
            } catch (Ts3Exception $e) {
                continue;
            }

            $uid = $info['client_unique_identifier']->toString();
            $key = \TsKey::where('uid', $uid)->first();
            if($key) {
                $ret[$key->user->cid] = [$tsUser, $key->user];
            }
        }

        return $ret;
    }
}

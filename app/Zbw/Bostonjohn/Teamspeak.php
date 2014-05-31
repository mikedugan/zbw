<?php namespace Zbw\Bostonjohn;
use TeamSpeak3\TeamSpeak3;


class Teamspeak {

    private $ts;
    public function __construct()
    {
        $args = \Config::get('zbw.teampseak');
        $this->ts = TeamSpeak3::factory("serverquery://".$args['user'].":".$args['password']."@".$args['host'].":".
        $args['query_port']."/?server_port=".$args['port']);
    }
}

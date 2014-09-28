<?php namespace Zbw\Forum; 

class ForumRepository
{
    private $db;
    private $url;

    public function __construct(UrlGenerator $url)
    {
        $this->db = \DB::connection('forum');
        $this->url = $url;
    }

    public function getRecentTopicsByBoard($board, $limit = 10)
    {
        return $this->db->select("
          SELECT t1.id_topic,poster_time,subject,body, CONCAT('http://bostonartcc.net/forum/index.php?topic=', t2.id_topic) as url
          FROM smf_topics AS t1 LEFT JOIN smf_messages AS t2 ON t2.id_topic=t1.id_topic WHERE t1.id_board=?
          GROUP BY t1.id_topic ORDER BY poster_time DESC limit ?",
        [$board, $limit]);
    }
} 

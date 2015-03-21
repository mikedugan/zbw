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

    public function getGroups()
    {
        return $this->db->select("SELECT * FROM smf_membergroups");
    }

    public function getGroup($name)
    {
        return $this->db->select("SELECT * FROM smf_membergroups WHERE group_name LIKE '%?%'", [$name]);
    }

    public function addUserToGroup($user_id, $group_id)
    {
        $this->db->update("UPDATE smf_members SET id_group=? WHERE id_member=?", [$group_id, $user_id]);
    }
} 

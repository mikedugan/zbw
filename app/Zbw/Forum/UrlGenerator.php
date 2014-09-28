<?php namespace Zbw\Forum; 

class UrlGenerator
{
    public function board($id)
    {
        return "index.php?board=$id";
    }

    public function forumUser($id)
    {
        return "index.php?action=profile;u=$id";
    }

    public function topic($id)
    {
        return "index.php?topic=$id";
    }
}

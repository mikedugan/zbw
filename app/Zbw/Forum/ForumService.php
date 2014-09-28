<?php namespace Zbw\Forum; 

use Decoda\Decoda;
use Decoda\Filter\TextFilter;
use Decoda\Filter\UrlFilter;
use Decoda\Hook\ClickableHook;

class ForumService
{
    private $repo;
    private $bb;

    public function __construct(ForumRepository $repo)
    {
        $this->repo = $repo;
        $this->bb = new Decoda(null, ['escapeHtml' => false]);
        $this->bb->defaults();
        $this->bb->addFilter(new TextFilter());
        $this->bb->addFilter(new UrlFilter());
        $this->bb->addHook(new ClickableHook());
    }

    public function getNotams()
    {
        $notams = $this->repo->getRecentTopicsByBoard(2, 10);
        foreach($notams as $notam) {
            $this->bb->reset($notam->body);
            $notam->body = \Str::limit($this->bb->parse(), 500, '...');
        }

        return $notams;
    }


} 

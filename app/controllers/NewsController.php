<?php

use Illuminate\Session\Store;
use Zbw\Cms\Contracts\NewsRepositoryInterface;
use Zbw\Forum\ForumService;

class NewsController extends BaseController
{
    private $news;
    private $forum;

    public function __construct(NewsRepositoryInterface $news, Store $session, ForumService $forum)
    {
        $this->news = $news;
        $this->forum = $forum;
        parent::__construct($session);
    }

    public function getIndex()
    {
        $data = [
          'news' => $this->news->controllers(),
          'notams' => $this->forum->getNotams()
        ];

        return View::make('cms.news.index', $data);
    }

    public function getAdminIndex()
    {
        $data = [
          'events'      => ['expired'  => $this->news->expiredEvents(5),
                            'upcoming' => $this->news->upcomingEvents(5),
                            'active'   => $this->news->activeEvents(5)],
          'staffnews'   => $this->news->staffNews(5),
          'generalnews' => $this->news->recentNews(5),
          'title'       => 'ZBW News Admin'
        ];

        return View::make('staff.pages.news', $data);
    }

    public function getPilotNews()
    {
        $data = [
          'news' => $this->news->pilots(),
          'notams' => $this->forum->getNotams()
        ];

        return View::make('cms.news.pilots', $data);
    }

    public function getCreate()
    {
        $data = [
          'facilities' => Facility::all(),
          'news_types' => NewsType::all(),
          'audiences'  => AudienceType::all(),
        ];

        return View::make('staff.news.create', $data);
    }

    public function postCreate()
    {
        if(! $this->news->add(\Input::all())) {
            return Redirect::back()->with('flash_error', $this->news->getErrors())->withInput();
        } else {
            return Redirect::home()->with('flash_success', 'Event created successfully!');
        }
    }

    public function getEdit($id)
    {
        $data = [
          'event'      => $this->news->get($id),
          'facilities' => Facility::all(),
          'news_types' => NewsType::all(),
          'audiences'  => AudienceType::all(),
        ];

        return View::make('staff.news.edit', $data);
    }

    public function postEdit()
    {
        if(! $this->news->update(Input::all())) {
            return Redirect::back()->with('flash_error', $this->news->getErrors())->withInput();
        } else {
            return Redirect::to('/staff/news')->with('flash_success', 'Event updated successfully');
        }
    }

    public function show($id)
    {
        $news = $this->news->findWithRelations($id);
        $data = [
          'title' => $news->title,
          'news'  => $news
        ];

        return View::make('cms.news.show', $data);
    }
}

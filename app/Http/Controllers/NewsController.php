<?php namespace Zbw\Http\Controllers;

use AudienceType;
use Facility;
use Illuminate\Session\Store;
use NewsType;
use Zbw\Cms\Contracts\NewsRepositoryInterface;
use Zbw\Forum\ForumService;

class NewsController extends BaseController
{
    private $news;
    private $forum;

    public function __construct(NewsRepositoryInterface $news, Store $session, ForumService $forum)
    {
        parent::__construct($session);
        $this->forum = $forum;
        $this->news = $news;
    }

    public function getIndex()
    {
        $this->setData('news', $this->news->controllers());
        $this->setData('notams', $this->forum->getNotams());

        return $this->view('cms.news.index');
    }

    public function getAdminIndex()
    {
        $this->setData('events', [
            'expired'  => $this->news->expiredEvents(5),
            'upcoming' => $this->news->upcomingEvents(5),
            'active'   => $this->news->activeEvents(5)
        ]);
        $this->setData('generalnews', $this->news->recentNews(5));
        $this->setData('staffnews', $this->news->staffNews(5));

        return $this->view('staff.pages.news');
    }

    public function getPilotNews()
    {
        $this->setData('news', $this->news->pilots());
        $this->setData('notams', $this->forum->getNotams());

        return $this->view('cms.news.pilots');
    }

    public function getCreate()
    {
        $data = [
            'facilities' => \Facility::all(),
            'news_types' => \NewsType::all(),
            'audiences'  => \AudienceType::all(),
        ];

        return \View::make('staff.news.create', $data);
    }

    public function postCreate()
    {
        if (! $this->news->add(\Input::all())) {
            return \Redirect::back()->with('flash_error', $this->news->getErrors())->withInput();
        } else {
            return \Redirect::home()->with('flash_success', 'Event created successfully!');
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

        return \View::make('staff.news.edit', $data);
    }

    public function postEdit()
    {
        if (! $this->news->update($this->request->all())) {
            return \Redirect::back()->with('flash_error', $this->news->getErrors())->withInput();
        } else {
            return \Redirect::to('/staff/news')->with('flash_success', 'Event updated successfully');
        }
    }

    public function show($id)
    {
        $news = $this->news->findWithRelations($id);
        $data = [
            'title' => $news->title,
            'news'  => $news
        ];

        return \View::make('cms.news.show', $data);
    }
}

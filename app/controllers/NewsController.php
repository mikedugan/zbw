<?php

use Zbw\Validators\NewsValidator;
use Zbw\Cms\NewsRepository;

class NewsController extends BaseController {

    private $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }
    
    public function getIndex()
    {
        $data = [
            'news' => $this->news->controllers()
        ];

        return View::make('cms.news.index', $data);
    }
    
    public function getPilotNews()
    {
        $data = [
            'news' => $this->news->pilots()
        ];

        return View::make('cms.news.pilots', $data);
    }

    public function getCreate()
    {
        $data = [
            'facilities' => Facility::all(),
            'news_types' => NewsType::all(),
            'audiences' => AudienceType::all(),
        ];
        return View::make('staff.news.create', $data);
    }

    public function postCreate()
    {
        $errors = $this->news->add(Input::all());
    	if(is_array($errors))
        {
            return Redirect::back()->with('flash_error', $errors)->withInput();
        }

        else
        {
            return Redirect::home()->with('flash_success', 'Event created successfully!');
        }
    }

    public function getEdit($id)
    {
        $data =[
            'event' => $this->news->find($id),
            'facilities' => Facility::all(),
            'news_types' => NewsType::all(),
            'audiences' => AudienceType::all(),
        ];
        return View::make('staff.news.edit', $data);
    }

    public function postEdit()
    {
        $errors = $this->news->update(Input::all());
        if(is_array($errors))
        {
            return Redirect::back()->with('flash_error', $errors)->withInput();
        }

        else return Redirect::to('/staff')->with('flash_success', 'Event updated successfully');
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

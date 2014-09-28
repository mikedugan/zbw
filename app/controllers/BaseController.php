<?php

use Laracasts\Commander\CommanderTrait;
use Illuminate\Session\Store;

abstract class BaseController extends Controller
{

    use CommanderTrait;

    /**
     * @var string
     */
    protected $layout = 'layouts.master';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $input;

    /**
     * @var Store
     */
    protected $session;

    /**
     * @var User
     */
    protected $current_user;

    /**
     * @param Store                $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
        $this->input = \Input::all();
        $this->data = [];

        if(\Sentry::check()) {
            $user = \Sentry::getUser();
            $this->current_user = $user;
            \View::share('me', $this->current_user);
            \View::share('messages', Zbw\Cms\MessagesRepository::newMessageCount($user->cid));
        }
    }

    protected function setData($key, $value = null)
    {
        if(is_array($key) && ! $value) $this->data = $key;
        else $this->data[$key] = $value;
    }

    /**
     * Setup the layout used by the controller.
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = \View::make($this->layout);
        }
    }

    /**
     * @param array $flash_data
     * @return void
     */
    protected function setFlash($flash_data)
    {
        foreach($flash_data as $title => $text)
        {
            $this->session->flash($title, $text);
        }
    }

    /**
     * @param      $path
     * @param null $data
     * @return void
     */
    protected function view($path, $data = null)
    {
        $this->layout->content = \View::make($path, is_null($data) ? $this->data : $data);
    }

    /**
     * @param int $statusCode
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectHome($statusCode = 302)
    {
        return \Redirect::home($statusCode);
    }

    /**
     * @param     $url
     * @param int $statusCode
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectTo($url, $statusCode = 302)
    {
        return \Redirect::to($url,$statusCode);
    }

    /**
     * @param       $route
     * @param array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectRoute($route, $data = [])
    {
        return \Redirect::route($route, $data);
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBack($data = [])
    {
        return \Redirect::back()->withInput()->with($data);
    }

    /**
     * @param $action
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectAction($action)
    {
        return \Redirect::action($action);
    }

    /**
     * @param string $default
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectIntended($default = '/')
    {
        $intended = \Session::get('auth.intended_redirect_url');
        if ($intended) {
            return $this->redirectTo($intended);
        }

        return \Redirect::to($default);
    }

    protected function json(array $data)
    {
        return Response::json($data);
    }

}

<?php  namespace Zbw\Cms; 

use Illuminate\Support\ServiceProvider;

/**
 * @package Zbw\Cms
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class CmsServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app->bind('Zbw\Cms\Contracts\CommentsRepositoryInterface', function() {
              return \App::make('Zbw\Cms\CommentsRepository');
          });
        $this->app->bind('Zbw\Cms\Contracts\FeedbackRepositoryInteface', function() {
              return new FeedbackRepository;
          });
        $this->app->bind('Zbw\Cms\Contracts\MenusRepositoryInterface', function () {
              return new MenusRepository;
          });
        $this->app->bind('Zbw\Cms\Contracts\NewsRepositoryInterface', function() {
              return \App::make('Zbw\Cms\NewsRepository');
          });
        $this->app->bind('Zbw\Cms\Contracts\PagesRepositoryInterface', function() {
              return \App::make('Zbw\Cms\PagesRepository');
          });
        $this->app->bind('Zbw\Cms\Contracts\MessagesRepositoryInterface', function() {
              return \App::make('Zbw\Cms\MessagesRepository');
          });
    }
} 

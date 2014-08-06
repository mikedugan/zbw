<?php  namespace Zbw\Training; 

use Illuminate\Support\ServiceProvider;

class TrainingServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app->bind('Zbw\Training\Contracts\ExamsRepositoryInterface', function() {
              return \App::make('Zbw\Training\ExamsRepository');
          });
        $this->app->bind('Zbw\Training\Contracts\TrainingSessionRepositoryInterface', function() {
              return \App::make('Zbw\Training\TrainingSessionRepository');
          });
        $this->app->bind('Zbw\Training\Contracts\CertificationRepositoryInterface', function() {
              return \App::make('Zbw\Training\CertificationRepository');
          });
        $this->app->bind('Zbw\Training\Contracts\QuestionsRepositoryInterface', function() {
              return \App::make('Zbw\Training\QuestionsRepository');
          });
    }
} 

<?php  namespace Zbw\Users; 

use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app->bind('Zbw\Users\Contracts\UserRepositoryInterface', function() {
              return new UserRepository;
          });
        $this->app->bind('Zbw\Users\Contracts\GroupsRepositoryInterface', function () {
              return \App::make('Zbw\Users\GroupsRepository');
          });
        $this->app->singleton('Zbw\Users\Contracts\StaffingRepositoryInterface', function() {
              return new StaffingRepository;
          });
        $this->app->bind('Zbw\Users\Contracts\VisitorApplicantRepositoryInterface', function() {
            return new VisitorApplicantRepository;
        });

        $this->app->bind('Zbw\Users\Contracts\ScheduleRepositoryInterface', function() {
            return new ScheduleRepository;
        });
    }
} 

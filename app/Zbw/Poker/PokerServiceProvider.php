<?php  namespace Zbw\Poker;

use Illuminate\Support\ServiceProvider;

class PokerServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app->bind('Zbw\Poker\Contracts\PokerRepositoryInterface', function() {
              return new PokerRepository;
          });
        $this->app->bind('Zbw\Poker\Contracts\PokerServiceInterface', function() {
              return \App::make('Zbw\Poker\PokerService');
          });
    }
} 

<?php  namespace Zbw\Validators; 

use Illuminate\Support\ServiceProvider;

class ZbwValidatorServiceProvider extends ServiceProvider {
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ZbwValidator', 'Zbw\Validators\ZbwValidator');
    }

} 

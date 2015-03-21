<?php namespace Zbw\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Bugsnag::setAppVersion(\Config::get('zbw.version'));
		if(\App::environment('production')) {
		    require_once public_path() . '/forum/smf_2_api.php';
		}

		\Bugsnag::setBeforeNotifyFunction('beforeBugsnagNotify');

		\Validator::extend('cid', function($attribute, $value, $parameters)
		{
		    return $value === 100 || ($value > 500000 && $value < 3000000);
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Laracasts\Commander\CommandTranslator',
		 	'Zbw\Core\CommandTranslator'
		);
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'Zbw\Services\Registrar'
		);

		\Blade::setRawTags('{{', '}}');
        \Blade::setContentTags('{{{', '}}}');
        \Blade::setEscapedContentTags('{{{', '}}}');
	}

}

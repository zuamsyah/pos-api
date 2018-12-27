<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		//
    }

    public function boot(UrlGenerator $url)
    {
		if(env('REDIRECT_HTTPS'))
		{
			$url->forceSchema('https');
		}
	}
}

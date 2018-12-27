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
    public function register(UrlGenerator $url)
    {
		if(env('REDIRECT_HTTPS'))
		{
			$url->forceScheme('https');
		}
    }
}

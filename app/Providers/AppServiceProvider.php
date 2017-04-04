<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.hnavigation', 'App\Http\ViewComposers\CparComposer@compose',
            'layouts.cpar-answer-nav', 'App\Http\ViewComposers\CparComposer@compose'
        );

        view()->composer([
            'cpars.create', 'cpars.index', 'cpars.show', 'cpars.edit', 'cpars.answer-cpar', 'pages.answer-cpar-login',
            'emails.cpars.cpar-created', 'emails.cpars.cpar-answered', 'emails.cpars.cpar-finalized',
            'emails.cpars.cpar-reviewed', 'emails.cpars.expired'
        ], function($view) {
            $client = new Client();
            $result = $client->get('http://na.dlbajana.xyz/api/users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('na_access_token')
                ]
            ]);
            $result = json_decode((string)$result->getBody());

            $view->with([
                'result' => $result
            ]);
        });

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

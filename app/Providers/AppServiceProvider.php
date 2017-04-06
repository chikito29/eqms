<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    protected $result;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        View::composer(
            'layouts.header', 'App\Http\ViewComposers\CparComposer@compose',
            'layouts.cpar-answer-nav', 'App\Http\ViewComposers\CparComposer@compose'
        );

        View::composer([
            'cpars.index', 'cpars.show', 'cpars.edit', 'cpars.answer-cpar',
            'pages.answer-cpar-login', 'cpars.review', 'pages.action-summary', 'cpars.create',
            'emails.cpars.cpar-created', 'emails.cpars.cpar-answered', 'emails.cpars.cpar-finalized',
            'emails.cpars.cpar-reviewed', 'emails.cpars.expired'
        ], function ($view) {
            $client = new Client();
            $result = $client->get('http://na.dlbajana.xyz/api/users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('na_access_token')
                ]
            ]);
            $result = json_decode((string)$result->getBody());

            $view->withResult($result);
        });




        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}

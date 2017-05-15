<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Section;
use App\NA;

class AppServiceProvider extends ServiceProvider {
    protected $result;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // Passing sections collection on header load
        View::composer(['headers.admin', 'headers.super-admin', 'headers.default'], function($view) {
            $view->with(['sections' => Section::with('documents')->get()]);
        });

        View::composer([
            'cpars.index', 'cpars.show', 'cpars.edit', 'cpars.answer-cpar',
            'pages.answer-cpar-login', 'cpars.review', 'pages.action-summary', 'cpars.create',
            'emails.cpars.cpar-created', 'emails.cpars.cpar-answered', 'emails.cpars.cpar-finalized',
            'emails.cpars.cpar-reviewed', 'emails.cpars.expired', 'settings.create', 'settings.index'
        ], function ($view) {
            $view->withEmployees(NA::users());
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

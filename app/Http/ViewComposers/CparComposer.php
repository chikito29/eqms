<?php

namespace App\Http\ViewComposers;

use App\Section;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\Cpar as CparRepositories;

class CparComposer {
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $cpars;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository $users
     * @return void
     */
    public function __construct(CparRepositories $cpars) {
        // Dependencies automatically resolved by service container...
        $this->cpars = $cpars;
    }

    /**
     * Bind data to the view.
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view) {
        $view->with([
            'sections' => Section::with('documents')->get()
        ]);
    }
}



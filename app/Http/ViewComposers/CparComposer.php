<?php

namespace App\Http\ViewComposers;

use App\Section;
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
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view) {
        $count = 0;
        foreach ($this->cpars->get() as $cpar) {
            if ($cpar->cparClosed->status <> 1 && $cpar->cparAnswered->status == 1 && $cpar->cparReviewed->status == 0) $count++;
        }

        if ($count > 0) session(['answered' => $count]);
        else session()->forget('answered');

        $view->with([
            'sections' => Section::with('documents')->get()
        ]);
    }
}



<?php

namespace App\Http\Middleware;

use App\CparClosed;
use App\Cpar;
use App\Mail\CparExpired;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Mail;

class CheckUpdates {

    protected $cpars;

    public function __construct(Cpar $cpars) {
        $this->cpars = $cpars;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        foreach ($this->cpars->get() as $cpar) {
            if (Carbon::now()->startOfDay()->gt(Carbon::parse($cpar->proposed_date)->startOfDay()) && $cpar->cparAnswered->status != 1 && $cpar->cparClosed->status != 1) {
                $cparClosed = CparClosed::find($cpar->id);
                $cparClosed->status = 1;
                $cparClosed->closed_by = "System";
                $cparClosed->remarks = "due date met but still unanswered";
                $cparClosed->notified = 1;
                $cparClosed->save();

                // TODO: cc QMR
                Mail::to('department-head@newsim.ph')->send(new CparExpired($cpar->id));
            }
        }

        return $next($request);
    }
}

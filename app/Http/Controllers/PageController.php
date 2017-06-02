<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\NA;
use App\ResponsiblePerson;
use App\RevisionLog;
use App\RevisionRequest;
use App\HelperClasses\Make;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {
    public function __construct() {
        $this->middleware('na.authenticate')->except(['pageNotFound', 'answerCparLoginPost', 'answerCparLogin']);
    }

    public function home() {
        $revisionLogs     = RevisionLog::all();
        $revisionRequests = RevisionRequest::with('reference_document')->get();

        return view('pages.home', compact('revisionLogs', 'revisionRequests'));
    }

    public function dashboard() {
        Make::log(
            'visited dashboard',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        if(request('user.role') != 'default') {
            $newlyCreatedCpars = Cpar::newlyCreated();

            $cparsOld = Cpar::where( DB::raw('YEAR(created_at)'), '=', Carbon::now()->year-1 )->get();
            $revisionRequestsOld = RevisionRequest::where( DB::raw('YEAR(created_at)'), '=', Carbon::now()->year-1 )->get();
            $cparsNew = Cpar::where( DB::raw('YEAR(created_at)'), '=', Carbon::now()->year )->get();
            $revisionRequestsNew = RevisionRequest::where( DB::raw('YEAR(created_at)'), '=', Carbon::now()->year )->get();
            $chartData        = RevisionRequest::selectRaw('date(created_at) AS day, COUNT(*) revision_request')->groupBy('day')->get();
            $chartDataCpar    = \App\Cpar::selectRaw('date(created_at) AS day, COUNT(*) cpar')->groupBy('day')->get();

            return view('pages.dashboard', compact('chartData', 'chartDataCpar', 'revisionRequestsOld', 'cparsOld', 'revisionRequestsNew', 'cparsNew', 'newlyCreatedCpars'));
        } else {
            return view('errors.404');
        }
    }

    public function actionSummary(Cpar $cpar) {
        $user = collect(NA::user($cpar->person_responsible));
        Make::log(
            'printed copy of CPAR of ' . $user['first_name'] .' '. $user['last_name'],
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return view('pages.action-summary', compact('cpar'));
    }

    public function answerCparLogin($id) {
        $cpar = Cpar::find($id);

        if ($cpar->cparClosed->status == 1) {
            return redirect('page-not-found');
        }
        else {
            if ($cpar <> NULL) {
                return view('pages.answer-cpar-login', compact('cpar'));
            }
            else {
                return redirect('page-not-found');
            }
        }
    }

    public function answerCparLoginPost(Cpar $cpar) {
        $this->validate(request(), [
            'code' => 'required'
        ]);

        if ($cpar->responsiblePerson == null) {
            return redirect("answer-cpar/login/$cpar->id")->withErrors(['code' => 'It seems like you already responded to this cpar, if you want an access to it, please contact QMR.']);
        }
        elseif (request('code') <> $cpar->responsiblePerson->code) {
            return redirect("answer-cpar/login/$cpar->id")->withErrors(['code' => 'Code provided do not exist']);
        } else {
            return redirect("answer-cpar/$cpar->id");
        }
    }

    public function pageNotFound() {
        return view('errors.page-not-found');
    }
}

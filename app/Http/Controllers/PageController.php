<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\ResponsiblePerson;
use App\RevisionLog;
use App\RevisionRequest;

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
            $revisionRequests = RevisionRequest::with('reference_document', 'attachments', 'section_b')->orderBy('created_at', 'desc')->get();
            $chartData        = RevisionRequest::selectRaw('date(created_at) AS day, COUNT(*) revision_request')->groupBy('day')->get();
            $chartDataCpar    = \App\Cpar::selectRaw('date(created_at) AS day, COUNT(*) cpar')->groupBy('day')->get();

            return view('pages.dashboard', compact('chartData', 'chartDataCpar', 'revisionRequests'));
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
        $user = collect(NA::user($cpar->person_responsible));
        Make::log(
            'access login page for CPAR of ' . $user['first_name'] .' '. $user['last_name'],
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

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
        $user = collect(NA::user($cpar->person_responsible));
        Make::log(
            'tried to answer CPAR of ' . $user['first_name'] .' '. $user['last_name'],
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

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

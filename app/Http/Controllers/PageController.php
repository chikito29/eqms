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
        $revisionRequests = RevisionRequest::with('reference_document', 'attachments', 'section_b')->orderBy('created_at', 'desc')->get();
        $chartData        = RevisionRequest::selectRaw('date(created_at) AS day, COUNT(*) revision_request')->groupBy('day')->get();

        return view('pages.dashboard', compact('chartData', 'revisionRequests'));
    }

    public function actionSummary(Cpar $cpar) {
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

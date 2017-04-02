<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\ResponsiblePerson;
use App\RevisionLog;
use App\RevisionRequest;

class PageController extends Controller {
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
        if ($cpar->cparReviewed->on_review <> 1) {
            if ($cpar <> NULL) {
                return view('pages.answer-cpar-login', compact('cpar'));
            }
            else {
                return redirect('page-not-found');
            }
        }
        elseif ($cpar->cparReviewed->on_review <> 1 && $cpar->cparClosed->status <> 1) {
            return view('cpars.cpar-on-review');
        }
        else {
            return view('errors.page-not-found');
        }
    }

    public function answerCparLoginPost(Cpar $cpar) {
        $this->validate(request(), [
            'code' => 'required'
        ]);

        if (request('code') == $cpar->responsiblePerson->code) {
            $responsiblePerson                = ResponsiblePerson::find($cpar->id);
            $responsiblePerson->authenticated = 1;
            $responsiblePerson->save();

            return redirect()->route('answer-cpar', $cpar->id);
        }
        else {
            return back()->withErrors(['code' => 'Provided code did not match any of our existing data. Please try again.']);
        }
    }

    public function pageNotFound() {
        return view('errors.page-not-found');
    }
}

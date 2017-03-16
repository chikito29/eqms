<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\RevisionLog;
use App\RevisionRequest;

class PageController extends Controller {
    public function home() {
        $revisionLogs = RevisionLog::all();
        $revisionRequests = RevisionRequest::with('reference_document')->get();

        return view('pages.home', compact('revisionLogs', 'revisionRequests'));
    }

    public function dashboard() {
        $revisionRequests = RevisionRequest::with('reference_document', 'attachments', 'section_b')->orderBy('created_at', 'desc')->get();
        $chartData = RevisionRequest::selectRaw('date(created_at) AS day, COUNT(*) revision_request')->groupBy('day')->get();
        return view('pages.dashboard', compact('chartData', 'revisionRequests'));
    }

    public function actionSummary(Cpar $cpar) {
        return view('pages.action-summary', ['cpar']);
    }
}

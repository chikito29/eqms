<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\RevisionLog;
use App\RevisionRequest;

class PageController extends Controller
{
    public function home() {
        $sections = Section::with('documents')->get();
        $revisionLogs = RevisionLog::all();
        $revisionRequests = RevisionRequest::with('reference_document')->get();
        return view('pages.home', compact('revisionLogs', 'revisionRequests'));
    }

    public function actionSummary() {
        return view('pages.action-summary');
    }
}

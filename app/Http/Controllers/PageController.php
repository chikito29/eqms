<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\RevisionLog;

class PageController extends Controller
{
    public function home() {
        $sections = Section::with('documents')->get();
        $revisionLogs = RevisionLog::all();
        return view('pages.home', compact('sections', 'revisionLogs'));
    }
}

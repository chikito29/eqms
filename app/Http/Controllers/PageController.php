<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;

class PageController extends Controller
{
    public function home() {
        $sections = Section::with('documents')->get();
        return view('pages.home', compact('sections'));
    }

    public function search() {
        return request()->all();
    }
}

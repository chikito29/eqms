<?php

namespace App\Http\Controllers;

use App\Cpar;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function cpars(...$ids) {
        return view('reports.cpars', compact('cpars'));
    }
}

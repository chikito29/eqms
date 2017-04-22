<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Cpar;
use App\CparAnswered;
use App\CparClosed;
use App\CparReviewed;
use App\EqmsUser;
use App\NA;
use App\ResponsiblePerson;
use Illuminate\Support\Facades\Storage;

class DevRoutes extends Controller
{
    function resetCpars() {
		$file_paths = Attachment::select('file_path')->get();
        Cpar::truncate();
        CparAnswered::truncate();
        CparReviewed::truncate();
        CparClosed::truncate();
        ResponsiblePerson::truncate();
		foreach($file_paths as $file_path) {
			unlink($file_path->file_path);
		}
		Attachment::truncate();

        return redirect('cpars');
    }

    function showNAUsers($chief = null, $id = NULL) {
        //return collect(collect(NA::users($chief, $id))->where('id', 5)->first());
		return collect(NA::users());
    }

    function showEqmsUsers($role = null){
        if($role == null) {
            return EqmsUser::all();
        } elseif($role == 'Admin' || $role == 'Document Controller') {
            return EqmsUser::where('role', $role)->get();
        }

}
    function showCpars() {
        return Cpar::all();
    }

    function test() {
        return Attachment::select('id')->get()->count() + 1;
    }
}

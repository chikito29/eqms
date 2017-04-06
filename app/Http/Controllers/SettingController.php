<?php

namespace App\Http\Controllers;

use App\EqmsUser;

class SettingController extends Controller
{
    protected $eqmsUsers;

	public function __construct(EqmsUser $eqmsUsers){
		$this->middleware('na.authenticate');
		$this->eqmsUsers = $eqmsUsers;
	}

    public function index(){
        return view('settings.index', ['eqmsUSers' => $this->eqmsUsers]);
    }

    public function create(){
        return view('settings.create');
    }

    public function store(){
        $this->validate(request(),[
            'user_id' => 'unique:eqms_users,user_id'
        ]);

        $eqms_user = new EqmsUser();
        $eqms_user->user_id = request('employee-id');
        $eqms_user->added_by = request('user.first_name') .' '. request('user.last_name');
        $eqms_user->role = request('role');
        $eqms_user->save();

        return view('sections.index');
    }
}

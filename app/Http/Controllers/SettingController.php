<?php

namespace App\Http\Controllers;

use App\EqmsUser;
use App\NA;

class SettingController extends Controller {
    protected $eqmsUsers;

    public function __construct(EqmsUser $eqmsUsers) {
        $this->middleware('na.authenticate');
        $this->eqmsUsers = $eqmsUsers->get();
    }

    public function index() {
        $employees = collect(NA::users());
        $naUsers   = $employees->whereNotIn('id', $this->eqmsUsers->pluck('user_id'));

        return view('settings.index', ['eqmsUsers' => $this->eqmsUsers, 'naUsers' => $naUsers, 'employees' => $employees]);
    }

    public function store() {
        $this->validate(request(), [
            'user_id'    => 'unique:eqms_users,user_id',
            'branch'     => 'required',
            'department' => 'required'
        ]);

        $eqms_user             = new EqmsUser();
        $eqms_user->user_id    = request('employee_id');
        $eqms_user->added_by   = request('user.first_name') . ' ' . request('user.last_name');
        $eqms_user->fullname   = request('fullname');
        $eqms_user->role       = request('role');
        $eqms_user->branch     = request('branch');
        $eqms_user->department = request('department');
        $eqms_user->email      = request('email');
        $eqms_user->save();

        return redirect()->route('settings.index');
    }

    public function destroy($id) {
        $eqmsUser = EqmsUser::find($id);
        $eqmsUser->delete();

        return back();
    }

    public function edit(EqmsUser $setting) {
        return view('settings.edit', ['user' => $setting]);
    }

    public function update(EqmsUser $setting) {
        $setting->user_id    = request('employee_id');
        $setting->added_by   = request('user.first_name') . ' ' . request('user.last_name');
        $setting->fullname   = request('fullname');
        $setting->role       = request('role');
        $setting->branch     = request('branch');
        $setting->department = request('department');
        $setting->save();

        return redirect()->route('settings.index');
    }
}
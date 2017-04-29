<?php

namespace App\Http\Controllers;

use App\EqmsUser;
use App\HelperClasses\Make;
use App\NA;

class SettingController extends Controller {
    protected $eqmsUsers;

    public function __construct(EqmsUser $eqmsUsers) {
        $this->middleware('na.authenticate');
        $this->eqmsUsers = $eqmsUsers->get();
    }

    public function index() {
        Make::log(
            'visited the eQMS Administrators index',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $employees = collect(NA::users());
        $naUsers   = $employees->whereNotIn('id', $this->eqmsUsers->pluck('user_id'));

        return view('settings.index', ['eqmsUsers' => $this->eqmsUsers, 'naUsers' => $naUsers, 'employees' => $employees]);
    }

    public function store() {
        Make::log(
            'tried to add an administrator',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

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

        Make::log(
            'successfully added an administrator',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect()->route('settings.index');
    }

    public function destroy($id) {
        $eqmsUser = EqmsUser::find($id);

        Make::log(
            'deleted administrator ' . $eqmsUser->fullname,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $eqmsUser->delete();

        return back();
    }

    public function edit(EqmsUser $setting) {
        return view('settings.edit', ['user' => $setting]);
    }

    public function update(EqmsUser $setting) {
        Make::log(
            'edited administrator ' . $setting->fullname,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $setting->user_id    = request('employee_id');
        $setting->added_by   = request('user.first_name') . ' ' . request('user.last_name');
        $setting->fullname   = request('fullname');
        $setting->role       = request('role');
        $setting->branch     = request('branch');
        $setting->department = request('department');
        $setting->email      = request('email');
        $setting->save();

        return redirect()->route('settings.index');
    }
}

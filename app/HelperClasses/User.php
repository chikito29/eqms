<?php
namespace App\HelperClasses;

use App\EqmsUser;

class User {
	static function isAdmin($id) {
		$user = EqmsUser::where('user_id', $id)->where('role', 'Admin')->get();
		if($user->count() > 0) {
			return true;
		} else {
			return false;
		}
	}

	static function isDocumentController($id) {
		$user = EqmsUser::where('user_id', $id)->where('role', 'Document Controller')->where('branch', 'Makati')->get();
		if($user->count() > 0) {
			return true;
		} else {
			return false;
		}
	}

	static function isSuperAdmin($id) {
		$user = EqmsUser::where('user_id', $id)->where('role', 'Document Controller')->where('branch', 'Makati')->get();
		if($user->count() > 0) {
			return true;
		} else {
			return false;
		}
	}
}

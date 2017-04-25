<?php
namespace App\HelperClasses;

use App\EqmsUser;
use App\NA;

class User {
	static function isSuperAdmin($id) {
		$user = collect(\App\NA::user($id))['type'];
		if($user == 'super-admin') {
			return true;
		} else {
			return false;
		}
	}
}

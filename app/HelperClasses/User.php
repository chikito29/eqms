<?php
namespace App\HelperClasses;

use App\EqmsUser;
use App\NA;

class User {
	static function isDefault() {

		if(request('user.role') == 'default') {
			return true;
		} else {
			return false;
		}
	}
}

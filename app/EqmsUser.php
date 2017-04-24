<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EqmsUser extends Model
{
	static function isMainDocumentController($id) {
		$user = EqmsUser::where('user_id', $id)->where('role', 'Document Controller')->where('branch', 'Makati')->get();
		if($user->count() > 0) {
			return true;
		} else {
			return false;
		}
	}

	static function isAdmin($id) {
		$user = EqmsUser::where('user_id', $id)->where('role', 'Admin')->get();
		if($user->count() > 0) {
			return true;
		} else {
			return false;
		}
	}

	static function getEqmsUser($id) {
		return EqmsUser::find($id);
	}

	static function adminEmail() {
		return \App\EqmsUser::where('role', 'Admin')->first()->email;
	}

	public function scopeMainDocumentController($query) {
		return $query->where('branch', 'Makati')->where('role', 'Document Controller')->first();
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EqmsUser extends Model
{
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

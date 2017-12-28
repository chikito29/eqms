<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public static function filterBy($query, $key, $value) {
        return $query->where($key, 'like', '%' .$value. '%');
    }

    public static function filterByDateRange($query, $from, $to) {
        return $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($from))
                     ->whereDate('created_at', '<=', \Carbon\Carbon::parse($to));
    }

    public function scopeSearchLogBy($query, $keyword) {
        return $query->Where('branch', $keyword)
                     ->orWhere('department', 'like', '%' .$keyword. '%')
                     ->orWhere('created_at', 'like', '%' .$keyword. '%');
    }
}

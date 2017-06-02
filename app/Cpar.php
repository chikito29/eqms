<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpar extends Model {
    use SoftDeletes;

    protected $guarded = [''];

    public function attachments() {
        return $this->hasMany(Attachment::class);
    }

    public function cparClosed() {
        return $this->hasOne(CparClosed::class);
    }

    public function cparReviewed() {
        return $this->hasOne(CparReviewed::class);
    }

    public function cparAnswered() {
        return $this->hasOne(CparAnswered::class);
    }

    public function responsiblePerson() {
        return $this->hasOne(ResponsiblePerson::class);
    }

    public static function filterBy($query, $key, $value) {
        return $query->where($key, 'like', '%' .$value. '%');
    }

    public static function filterByDateRange($query, $from, $to) {
        return $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($from))
                     ->whereDate('created_at', '<=', \Carbon\Carbon::parse($to));
    }

    public function scopeSearchCparBy($query, $keyword) {
        return $query->where('cpar_number', 'like', '%' .$keyword. '%')
                     ->orWhere('branch', $keyword)
                     ->orWhere('department', $keyword)
                     ->orWhere('created_at', 'like', '%' .$keyword. '%')
                     ->orWhere('severity', 'like', '%' .$keyword. '%');
    } 
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CparReviewed extends Model {

    protected $table = 'cpar_reviewed';
    protected $fillable = ['status', 'cpar_id'];

    public function cpar() {
        return $this->belongsTo(Cpar::class);
    }
}

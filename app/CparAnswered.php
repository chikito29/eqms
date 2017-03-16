<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CparAnswered extends Model {

    protected $table = 'cpar_answered';
    protected $fillable = ['status', 'cpar_id'];

    public function cpar() {
        return $this->belongsTo(Cpar::class, 'cpar_answered_id');
    }
}

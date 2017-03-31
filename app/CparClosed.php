<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CparClosed extends Model {

    protected $table = 'cpar_closed';
    protected $primaryKey = 'cpar_id';
    protected $fillable = ['status', 'cpar_id'];

    public function cpar() {
        return $this->belongsTo(Cpar::class);
    }
}

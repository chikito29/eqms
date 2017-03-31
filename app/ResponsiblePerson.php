<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsiblePerson extends Model {
    use SoftDeletes;

    protected $table = 'responsible_persons';
    protected $fillable = ['cpar_id', 'code'];
    protected $dates = ['deleted_at'];

    public function cpar() {
        return $this->belongsTo(Cpar::class);
    }
}

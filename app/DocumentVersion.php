<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model
{
    protected $guarded = [''];

    public function cpar() {
        return $this->belongsTo(Cpar::class);
    }
}

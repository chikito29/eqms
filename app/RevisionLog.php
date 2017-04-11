<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisionLog extends Model
{
    public function document() {
        return $this->belongsTo(Document::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    protected $table = 'attachments';

    public function revision_request() {
        return $this->belongsTo('App\RevisionRequest', 'revision_request_id');
    }

    public function cpar() {
        return $this->belongsTo(Cpar::class);
    }
}

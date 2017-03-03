<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RevisionRequest extends Model
{
    use SoftDeletes;

    protected $table = 'revision_requests';

    public function targetDocument() {
        return $this->belongsTo('App\Document', 'target_document');
    }
}

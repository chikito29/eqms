<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RevisionRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'revision_requests';

    public function reference_document() {
        return $this->belongsTo('App\Document', 'reference_document_id');
    }

    public function attachments() {
        return $this->hasMany('App\Attachment', 'revision_request_id');
    }
}

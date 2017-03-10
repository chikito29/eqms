<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RevisionRequest;

class RevisionRequestSectionC extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'revision_requests_section_c';

    public function revision_request() {
        return $this->belongsTo(RevisionRequest::class, 'revision_requests_id');
    }
}

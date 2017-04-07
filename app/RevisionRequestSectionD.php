<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RevisionRequest;

class RevisionRequestSectionD extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'revision_requests_section_d';
    protected $guarded = [];

    public function revision_request() {
        return $this->belongsTo(RevisionRequest::class, 'revision_requests_id');
    }
}

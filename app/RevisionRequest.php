<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Document;
use App\Attachment;
use App\RevisionRequestSectionB;
use App\RevisionRequestSectionC;
use App\RevisionRequestSectionD;


class RevisionRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'revision_requests';

    public function reference_document() {
        return $this->belongsTo(Document::class, 'reference_document_id');
    }

    public function attachments() {
        return $this->hasMany(Attachment::class, 'revision_request_id');
    }

    public function section_b() {
        return $this->hasOne(RevisionRequestSectionB::class, 'revision_request_id');
    }

    public function section_c() {
        return $this->hasOne(RevisionRequestSectionC::class, 'revision_request_id');
    }

    public function section_d() {
        return $this->hasOne(RevisionRequestSectionD::class, 'revision_request_id');
    }
}

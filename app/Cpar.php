<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpar extends Model
{
    use SoftDeletes;

    protected $guarded = [''];

    public function attachments() {
        return $this->hasMany(Attachment::class);
    }

    public function documentVersion() {
        return $this->hasOne(DocumentVersion::class);
    }
}

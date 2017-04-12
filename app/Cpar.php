<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cpar extends Model {
    use SoftDeletes;

    protected $guarded = [''];

    public function attachments() {
        return $this->hasMany(Attachment::class);
    }

    public function cparClosed() {
        return $this->hasOne(CparClosed::class);
    }

    public function cparReviewed() {
        return $this->hasOne(CparReviewed::class);
    }

    public function cparAnswered() {
        return $this->hasOne(CparAnswered::class);
    }

    public function responsiblePerson() {
        return $this->hasOne(ResponsiblePerson::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessRequest extends Model
{
    use SoftDeletes;

    protected $table = 'access_requests';
    protected $dates = ['deleted_at'];
}

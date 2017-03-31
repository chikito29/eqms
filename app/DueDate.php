<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DueDate extends Model
{
    use Notifiable;

    public function cpar(){
        return $this->belongsTo(Cpar::class);
    }
}

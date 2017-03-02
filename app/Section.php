<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $searchable = [
		'columns' => [
		    'sections.name' => 10,
		    'profiles.body' => 5,
		],
		'joins' => [
		    'documents' => ['sections.id','documents.section_id'],
		],
	];

	public function documents() {
	    return $this->hasMany('App\Document');
	}
}

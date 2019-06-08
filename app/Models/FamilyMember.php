<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name',
    	'family_type',
    	'age',
    	'occupation'
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

}

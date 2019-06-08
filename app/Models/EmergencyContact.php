<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyContact extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name',
    	'relationship',
    	'address',
    	'contact',
	];
	
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];
}

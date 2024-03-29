<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelephoneNumber extends Model
{
    use SoftDeletes;

    protected $fillable = ['number'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

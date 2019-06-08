<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Branch;
use App\Models\City;
use App\Models\Region;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'location_name',
        'city_id',
        'enabled',
        'last_modified_by'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public static function filter($fields, $value)
    {
        if (!in_array('enabled', $fields)) {
            array_push($fields, 'enabled');
        }

        $location = Location::with('city.region')
            ->whereHas('city.region', function ($query) use ($value) {
                return $query->whereIn('id', $value);
            })
            ->select($fields);

        return $location;
    }
}

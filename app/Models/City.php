<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\City;
use App\Models\Location;
use App\Models\Region;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = ['city_name', 'enabled', 'last_modified_by', 'region_id'];
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public static function filter($fields, $value)
    {
        if (!in_array("region_id", $fields)) {
            array_push($fields, "region_id");
        }
        
        return City::with(['region'])
            ->where("region_id", $value)
            ->whereHas('region', function ($q) {
                return $q->orderBy('region_name');
            })
            ->select($fields);
    }
}

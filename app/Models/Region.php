<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models \{
    Client, Brand, City, Location
};

class Region extends Model
{
    use SoftDeletes;


    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_region', 'region_id', 'client_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_region', 'region_id', 'brand_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function locations()
    {
        return $this->hasManyThrough(Location::class, City::class);
    }

	public static function filter($fields, $value)
	{
		if (!in_array("enabled", $fields)) {
			array_push($fields, "enabled");
		}

		return Region::where("enabled", $value)->select($fields);
	}
}
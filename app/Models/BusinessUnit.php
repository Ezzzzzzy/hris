<?php

namespace App\Models;

use App\Classes\Helper;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessUnit extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function branches()
    {
        return $this->hasManyThrough(Branch::class, Brand::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function getBusinessUnits($client_id, $params = [])
    {
        $result = new static;
        $helper = new Helper($result);
        $result = $result->where('client_id', $client_id)->with('branches.branchWorkHistory');
        $params = collect($params);
        $limit = $params->get('limit', 10);

        // search
        if ($params->get('q', false)) {
            $keyword = $params->get('q', false);
            $result = $result->where('business_unit_name', 'LIKE', "%$keyword%")
                             ->orWhere('code', 'LIKE', "%$keyword%");
        }

        // filter
        if (gettype($params->get('enabled')) === 'string') {
            $result = $helper->filter('enabled', $params['enabled']);
        }

        // all
        if ($params->get('all', false)) {
            return $result->where('enabled', 1)->get();
        }

        return $result->where('client_id', $client_id)->paginate($limit);
    }
}

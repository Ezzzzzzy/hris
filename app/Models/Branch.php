<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Brand;
use App\Models\Region;
use App\Models\Location;
use App\Models\BranchWorkHistory;

class Branch extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function branchWorkHistory()
    {
        return $this->hasMany(BranchWorkHistory::class)
                    ->whereRaw(("branch_work_histories.date_end >= NOW() OR branch_work_histories.date_end IS NULL"));
    }

    public function branchWorkHistoryNew()
    {
        return $this->hasMany(BranchWorkHistory::class, "branch_id");
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public static function filter($value, $filter_type)
    {
        if ($filter_type == "region") {
            return Branch::with(['location.city.region'])
            ->whereHas('location.city.region', function ($query) use ($value) {
                return $query->where('region_id', $value);
            })
            ->select();
        }
        
        return Branch::with(['location.city'])
            ->whereHas('location.city', function ($query) use ($value) {
                return $query->where('city_id', $value);
            })
            ->select();
    }

    public static function getBranches($client_id, $params = [])
    {
        $result = new static;
        $result = $result->whereHas('brand', function ($q) use ($client_id) {
            $q->where('client_id', $client_id);
        });
        $params = collect($params);
        $limit = $params->get('limit', 10);

        // search
        if ($params->get('q', false)) {
            $keyword = $params->get('q', false);
            $result = $result->where('branch_name', 'LIKE', "%$keyword%");
        }

        // filter
        if (gettype($params->get('enabled')) === 'string') {
            $result = $result->where('enabled', $params['enabled']);
        }

        // REGION filter
        if ($params->get('region')) {
            $result = $result->whereHas('location.city', function ($q) use ($params) {
                $q->where('region_id', $params['region']);
            });
        }

        // REGION filter
        if ($params->get('city', false)) {
            $result = $result->whereHas('location.city', function ($q) use ($params) {
                $q->where('city_id', $params['city']);
            });
        }

        // all
        if ($params->get('all', false)) {
            return $result->where('enabled', 1)->get();
        }

        return $result->whereHas('brand', function ($q) use ($client_id) {
            $q->where('client_id', $client_id);
        })->paginate($limit);
    }
}

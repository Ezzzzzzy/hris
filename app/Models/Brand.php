<?php

namespace App\Models;

use App\Classes\Helper;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\BranchWorkHistory;
use App\Models\Client;
use App\Models\Region;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, "client_id");
    }
    
    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class, "business_unit_id");
    }
    
    public function branches()
    {
        return $this->hasMany(Branch::class, "brand_id");
    }

    public function branchWorKhistory()
    {
        return $this->hasManyThrough(BranchWorkHistory::class, Branch::class);
    }

    public function cities()
    {
        return $this->hasMany(Branch::class)
        ->join("locations", "locations.id", "=", "branches.location_id")
        ->join("cities", "cities.id", "=", "locations.city_id");
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'brand_region', 'brand_id', 'region_id');
    }
    
    public function getMembers()
    {
        $result = Brand::findOrFail($this->id);
        $members = $result->with([
            "branches" => function ($q) {
                $q->join("brands", "brands.id", "=", "branches.brand_id");
                $q->join("business_units", "business_units.id", "=", "brands.business_unit_id");
                $q->join("branch_work_histories", "branch_work_histories.branch_id", "=", "branches.id");
                $q->join("client_work_histories", "client_work_histories.id", "=", "branch_work_histories.client_work_history_id");
                $q->join("members", "members.id", "=", "client_work_histories.member_id");
                $q->join("employment_statuses", "employment_statuses.id", "=", "branch_work_histories.employment_status_id");
                $q->where("employment_statuses.type", "active");
                $q->join("positions", "positions.id", "=", "branch_work_histories.position_id");
                $q->join("locations", "locations.id", "=", "branches.location_id");
                $q->select(
                    "business_units.id as business_unit_id",
                    "business_units.business_unit_name",
                    "branches.brand_id",
                    "branches.branch_name as branch",
                    \DB::raw("CONCAT(members.first_name,' ', members.last_name) as name"),
                    'members.gender',
                    \DB::raw("branch_work_histories.id as bwh_id"),
                    \DB::raw("client_work_histories.id as cwh_id"),
                    "branch_work_histories.date_start",
                    "client_work_histories.employee_id",
                    "positions.id as position_id",
                    "positions.position_name as position",
                    "locations.id as location_id",
                    "locations.location_name as location",
                    "employment_statuses.status_name",
                    "employment_statuses.color",
                    "employment_statuses.id as status_id"
                ); // ACTIVE MEMBERS BY EMPLOYMENT STATUS
            }
            ])
        ->where("id", $this->id)
        ->first()
        ->branches;

        foreach ($members as $member) {
            $date_start = Carbon::parse($member->date_start);
            $member['date_start'] = $date_start->toFormattedDateString();
        }

        return $members;
    }

    public static function getBrands($client_id, $params = [])
    {
        $result = new static;
        $helper = new Helper($result);
        $result = $result->where('client_id', $client_id);
        $params = collect($params);
        $limit = $params->get('limit', 10);

        // search
        if ($params->get('q', false)) {
            $keyword = $params->get('q', false);
            $result = $result->where('brand_name', 'LIKE', "%$keyword%");
        }

        // filter
        if (gettype($params->get('enabled')) === 'string') {
            $result = $helper->filter('enabled', $params['enabled']);
        }

        // filter
        if ($params->get('business_unit_id', false)) {
            $result = $helper->filter('business_unit_id', $params['business_unit_id']);
        }

        // all
        if ($params->get('all', false)) {
            return $result->where('enabled', 1)->get();
        }

        return $result->where('client_id', $client_id)->paginate($limit);
    }
}

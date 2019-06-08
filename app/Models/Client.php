<?php

namespace App\Models;

use App\Classes\Helper;

use App\Models\BranchWorkHistory;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\BusinessUnit;
use App\Models\ClientWorkHistory;
use App\Models\Region;
use App\Models\Role;
use App\Models\RoleHasClient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    
    public static function getClients($client_ids = [], $params = [])
    {
        $result = new static;
        $helper = new Helper($result);
        $params = collect($params);
        $limit = $params->get('limit', 10);

        // search
        if ($params->get('q', false)) {
            $keyword = $params->get('q', false);
            $result = $result->where('client_name', 'LIKE', "%$keyword%")->orWhere('code', 'LIKE', "%$keyword%");
        }

        // sort
        if ($params->get('_sort', false)) {
            $result = $helper->sort($params['_sort']);
        }

        // filter
        if (!$params->get('enabled', true)) {
            $result = $helper->filter('status', $params['enabled']);
        }

        // all
        if ($params->get('all', false)) {
            return $result->where('enabled', 1)->get();
        }

        if (count($client_ids) == 0) {
            return $result->paginate($limit);
        }

        return $result->whereIn('id', $client_ids)->paginate($limit);
    }

    public function businessUnits()
    {
        return $this->hasMany(BusinessUnit::class);
    }

    public function branches()
    {
        return $this->hasManyThrough(Branch::class, Brand::class);
    }

    public function members()
    {
        return $this->hasMany(ClientWorkHistory::class, "client_id", "id")
            ->whereRaw("(client_work_histories.date_end >= NOW() OR client_work_histories.date_end IS NULL)");
    }

    public function currentMembers()
    {
        return $this->hasMany(ClientWorkHistory::class)->whereNull('date_end')->where('date_end', '>=', Carbon::today());
    }

    public function membersInformation()
    {
        return $this->hasManyThrough(BranchWorkHistory::class, ClientWorkHistory::class)
            ->select([
                \DB::raw("CONCAT(members.first_name,' ', members.last_name) as full_name"),
                "client_work_histories.id as cwh_id",
                "members.gender as gender",
                "positions.position_name as position",
                "client_work_histories.date_start",
                "employment_statuses.status_name as employment_status",
                "branches.id as branch_id",
                "branch_work_histories.id",
            ])
            ->whereRaw("(client_work_histories.date_end <= NOW() OR client_work_histories.date_end IS NULL)")
            ->join("members", "client_work_histories.member_id", "members.id")
            ->join("branches", "branch_work_histories.branch_id", "branches.id")
            ->join("positions", "branch_work_histories.position_id", "positions.id")
            ->join("employment_statuses", "branch_work_histories.employment_status_id", "employment_statuses.id");
    }

    public function brandsWithoutBusinessUnit()
    {
        return $this->hasMany(Brand::class);
    }

    public function brands()
    {
        //modified
        return $this->hasMany(Brand::class);
        // original
        // return $this->hasManyThrough(Brand::class, BusinessUnit::class);
    }

    public function getBranches()
    {
        $client = Client::where("id", $this->id)
            ->with([
                "brandsWithoutBusinessUnit.branches",
                "brands.branches",
                "brands.branches.location.city.region",
                "brands.branches.branchWorkHistory",
            ])
            ->first();

        $merged_brands = $client->brandsWithoutBusinessUnit->merge($client->brands);

        if ($merged_brands->isEmpty()) {
            return collect([]);
        }
        $branches = [];
        foreach ($merged_brands as $brand) {
            foreach ($brand->branches as $branch) {
                $updated_at = Carbon::parse($branch->updated_at)->toFormattedDateString();
                $result["branch_id"] = $branch->id;
                $result['brand_id'] = $brand->id;
                $result['brand_name'] = $brand->brand_name;
                $result["branch_name"] = $branch->branch_name;
                $result["location_id"] = $branch->location->id;
                $result["location_name"] = $branch->location->location_name;
                $result["city_id"] = $branch->location->city->id;
                $result["city_name"] = $branch->location->city->city_name;
                $result["region_id"] = $branch->location->city->region->id;
                $result["region_name"] = $branch->location->city->region->region_name;
                $result["members_count"] = $branch->branchWorkHistoryNew->count();
                $result["enabled"] = $branch->enabled;
                $result["last_modified"] = $updated_at;
                $branches[] = $result;
            }
        }

        return ($merged_brands->isNotEmpty()) ? collect($branches) : collect([]);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'client_region', 'client_id', 'region_id');
    }

    public function roleHasClients()
    {
        return $this->hasMany(RoleHasClients::class);
    }

    public function clientWorkHistory()
    {
        return $this->hasMany(clientWorkHistory::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_clients', 'role_id', 'client_id');
    }

    public function membersPerBrand()
    {
        $hello = Client::findOrFail($this->id);
        $hello = $hello->where("id", $this->id)
            ->with([
                "brands" => function ($q) {
                    $q->join("branches", "brands.id", "branches.brand_id");
                    $q->select("branches.id");
                },
            ])
            ->first();

        $branches_id = $hello->brands->map(function ($value) {
            return $value->id;
        })->sort()->values();

        $members = \DB::table("branch_work_histories AS b")
            ->whereIn("branch_id", $branches_id)
            ->join("branches", "branches.id", "b.branch_id")
            ->join("client_work_histories AS c", "c.id", "b.client_work_history_id")
            ->join("employment_statuses as es", "es.id", "b.employment_status_id")
            ->join("positions as p", "p.id", "b.position_id")
            ->select(
                "branches.branch_name",
                "c.employee_id",
                "branches.branch_name",
                "b.date_start",
                "p.position_name",
                "es.status_name"
            )
            ->groupBy("c.member_id")
            ->where("es.type", "active")
            ->where("c.client_id", $this->id)
            ->get();

        foreach ($members as $member) {
            $member->date_start = Carbon::parse($member->date_start)->toFormattedDateString();
        }

        return $members;
    }

    public function getMembers()
    {
        $client = \DB::table("clients AS c")
            ->select([
                "bwh.id as bwh_id",
                \DB::raw("cwh.id AS cwh_id, MAX(bwh.id) AS bwh_id"),
                \DB::raw("CONCAT(m.first_name,' ', m.last_name) as full_name"),
                "cwh.member_id as member_id",
                "p.id as position_id",
                "p.position_name as position",
                "b.branch_name",
                "brands.id as brand_id",
                "brands.brand_name",
                "cwh.date_start",
                "bu.business_unit_name",
                "l.id as location_id",
                "l.location_name",
                "m.gender as gender",
                "es.id as status_id",
                "es.status_name as employment_status",
                "es.color as color"
            ])
            ->join("client_work_histories AS cwh", "cwh.client_id", "c.id")
            ->join("members AS m", "cwh.member_id", "m.id")
            ->leftJoin(
                // \DB::raw("(SELECT *
                // FROM `branch_work_histories` A
                // WHERE A.date_start < NOW()
                // ORDER BY A.date_start DESC) AS bwh"),
                \DB::raw("(
                SELECT * FROM `branch_work_histories` A
                WHERE A.id = (
                    SELECT MAX(B.id)
                    FROM `branch_work_histories` B
                    WHERE A.client_work_history_id = B.client_work_history_id)
                ) AS bwh"),
                function ($join) {
                    $join->on("cwh.id", "bwh.client_work_history_id");
                }
            )
            ->leftJoin("branches AS b", "b.id", "bwh.branch_id")
            ->leftjoin("brands", "brands.id", "b.brand_id")
            ->leftjoin("locations AS l", "l.id", "b.location_id")
            ->leftjoin("business_units AS bu", "bu.id", "brands.business_unit_id")
            ->leftJoin("positions AS p", "bwh.position_id", "p.id")
            ->leftJoin("employment_statuses AS es", "es.id", "bwh.employment_status_id")
            ->whereRaw("(cwh.date_end >= NOW() OR cwh.date_end IS NULL)")
            ->where("c.id", $this->id)
            ->groupBy("cwh.id")
            ->get();


        $bwh_ids = $client->map(function ($item, $key) {
            return $item->bwh_id;
        });

        $da = \DB::table("disciplinary_actions AS da")
            ->select(["da.branch_work_history_id as bwh_id", "da.id as da_id", "da.status"])
            ->whereIn("branch_work_history_id", $bwh_ids)
            ->get()
            ->values();

        $clients = [];
        foreach ($client as $key => $value) {
            $result = [];
            $date_start = new Carbon($value->date_start);
            $result["cwh_id"] = $value->cwh_id;
            $result["bwh_id"] = $value->bwh_id;
            $result["name"] = $value->full_name;
            $result["position_id"] = $value->position_id;
            $result["position"] = $value->position;
            $result["gender"] = $value->gender;
            $result["date_start"] = $date_start->toFormattedDateString();
            // $result["date_end"] = !is_null($value->date_end) ? Carbon::parse($value->date_end)->toFormattedDateString() : "NULL DATE";
            $result["status_id"] = $value->status_id;
            $result["color"] = $value->color;
            $result["employment_status"] = is_null($value->bwh_id) ? "Transition" : $value->employment_status;
            $result["branch"] = $value->branch_name;
            $result["location_id"] = $value->location_id;
            $result["location"] = $value->location_name;
            $result["brand_id"] = $value->brand_id;
            $result["brand"] = $value->brand_name;
            $result["business_unit"] = $value->business_unit_name;

            /**
             * DA status
             * 0 = NA, 1 = Pending, 2 = Resolved
             */
            $disciplinary_actions = $da->where("bwh_id", $value->bwh_id)->values();
            if ($disciplinary_actions->count() > 0) {
                $da_status = $disciplinary_actions->map(function ($item, $key) {
                    return $item->status;
                })->search(1);

                $result["disciplinary_action"] = $da_status ? "Pending" : "Resolved";
            } else {
                $result["disciplinary_action"] = "NA";
            }

            $clients[] = $result;
        }

        return collect($clients)->sortBy("cwh_id")->values();
    }

    public function getBrands()
    {
        $client = $this->where("id", $this->id)
            ->with([
                "brandsWithoutBusinessUnit",
                "brandsWithoutBusinessUnit.branches.branchWorkHistory" => function ($q) {
                    $q->select(
                        "branch_id",
                        \DB::raw("COUNT(branch_id) AS members_count")
                    );
                    // $q->join("employment_statuses AS es", "es.id", "branch_work_histories.employment_status_id");
                    $q->whereRaw("(branch_work_histories.date_end >= NOW() OR branch_work_histories.date_end IS NULL)");
                // $q->where("es.type", "active");
                },
                "brands",
                "brands.businessUnit:id,code,business_unit_name",
                "brands.branches.branchWorkHistory" => function ($q) {
                    $q->select(
                        "branch_id",
                        \DB::raw("COUNT(branch_id) AS members_count")
                    );
                    // $q->join("employment_statuses AS es", "es.id", "branch_work_histories.employment_status_id");
                    $q->whereRaw("(branch_work_histories.date_end >= NOW() OR branch_work_histories.date_end IS NULL)");
                // $q->where("es.type", "active");
                },
            ])
            ->first();

        $merged_brands = $client->brandsWithoutBusinessUnit->merge($client->brands);

        if ($merged_brands->isEmpty()) {
            return collect([]);
        }


        $brands = [];
        foreach ($merged_brands as $key => $value) {
            $updated_at = Carbon::parse($value->updated_at)->toFormattedDateString();
            $result = [];
            $result["id"] = $value->id;
            $result["brand_name"] = ucfirst($value->brand_name);
            $result["last_modified_by"] = $value->last_modified_by;
            $result["updated_at"] = $updated_at;
            $result["business_unit_code"] = !is_null($value->businessUnit) ? strtoupper($value->businessUnit->code) : "-----";
            $result["business_unit_name"] = !is_null($value->businessUnit) ? $value->businessUnit->business_unit_name : "-----";
            $result["branches_count"] = $value->branches->count();
            $result["enabled"] = $value->enabled;
            if ($value->branches->count() === 0) {
                $result["members_count"] = 0;
            } else {
                if ($value->branches->count() === 0) {
                    $result["members_count"] = 0;
                } else {
                    if ($value->branches->first()->branchWorkHistory->count() === 0) {
                        $result["members_count"] = 0;
                    } else {
                        $result["members_count"] = $value->branches->first()->branchWorkHistory->first()->members_count;
                    }
                }
            }

            $result["business_unit_id"] = !is_null($value->businessUnit) ? $value->businessUnit->id : null;

            $clients[] = $result;
        }

        return collect($clients);
    }

    public function clientBrands()
    {
        $businessUnit = Client::with([
            "businessUnit" => function ($q) {
                $q->select(
                    "business_units.id",
                    "business_units.business_unit_name",
                    "business_units.code",
                    "business_units.enabled",
                    "business_units.client_id"
                );
            },
            "businessUnit.brand:id,business_unit_id,brand_name,enabled",
        ])->get(["id"]);

        return $businessUnit;
    }

    public function clientBusinessUnit()
    {
        $client = Client::with([
            "businessUnit" => function ($q) {
                $q->select(
                    "business_units.id",
                    "business_units.business_unit_name",
                    "business_units.code",
                    "business_units.enabled",
                    "business_units.client_id"
                );
            },
        ])->get(["id"]);

        return $client;
    }
}

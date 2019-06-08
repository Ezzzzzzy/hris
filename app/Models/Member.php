<?php

namespace App\Models;

use Validator;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use Carbon\Carbon;
use App\Models\AddressCity;
use App\Models\BranchWorkHistory;
use App\Models\Client;
use App\Models\ClientWorkHistory;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\EmergencyContact;
use App\Models\EmploymentHistory;
use App\Models\EmploymentStatus;
use App\Models\FamilyMember;
use App\Models\Location;
use App\Models\Member;
use App\Models\MobileNumber;
use App\Models\Position;
use App\Models\School;
use App\Models\TelephoneNumber;
use App\Models\TenureType;

class Member extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'atm',
        'birthdate',
        'birthplace',
        'civil_status',
        'email_address',
        'existing_member_id',
        'extension_name',
        'fb_address',
        'first_name',
        'gender',
        'height',
        'last_name',
        'last_modified_by',
        'maternity_leave',
        'middle_name',
        'new_member_id',
        'nickname',
        'pag_ibig_num',
        'present_address',
        'present_address_city',
        'permanent_address',
        'permanent_address_city',
        'philhealth_num',
        'rate',
        'sss_num',
        'tin',
        'weight',
    ];

    private $modifiers = [
        'Jerome Agapay',
        'Rachelle Uy',
        'Neil Nato',
        'Nards Paragas',
        'Princess De Guzman',
        'Emerson Rivera',
        'Daryl Elvinson'
    ];

    public static $prefix = 'PS';
    public static $suffix = 'HRIS';

    public function branchWorkHistory()
    {
        return $this->hasManyThrough(BranchWorkHistory::class, ClientWorkHistory::class)
            ->orderBy('branch_work_histories.date_end', 'desc');
    }

    public function statusHistory()
    {
        // for Status History
        // return $member->branchWorkHistory()
        //         ->where('branch_work_histories.client_work_history_id', $request->client_work_history_id)
        //         ->where('branch_work_histories.position_id', $request->position_id)
        //         ->where('branch_work_histories.branch_id', $request->branch_id)
        //         ->join('branches', 'branches.id', '=', 'branch_work_histories.branch_id')
        //         ->where('branches.brand_id', $request->brand_id)
        //         ->get();
    }

    public function clients()
    {
        return $this->belongsToMany(
            Client::class,
            'client_work_histories',
            'member_id',
            'client_id'
        );
    }

    public function clientWorkHistory()
    {
        return $this->hasMany(ClientWorkHistory::class, 'member_id');
    }

    public function latestClientWorkHistory()
    {
        return $this->hasMany(ClientWorkHistory::class)->orderBy("id", "DESC");
    }

    public function tenureTypes()
    {
        return $this->belongsToMany(TenureType::class, 'client_work_histories', 'member_id', 'tenure_type_id');
    }

    public function presentCities()
    {
        return $this->belongsTo('App\Models\AddressCity', 'address_cities_present_id');
    }

    public function permanentCities()
    {
        return $this->belongsTo(AddressCity::class, 'address_cities_permanent_id');
    }

    public function mobileNumbers()
    {
        return $this->hasMany(MobileNumber::class, 'member_id');
    }

    public function telephoneNumbers()
    {
        return $this->hasMany(TelephoneNumber::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public static function allMembers()
    {
        $employee_status = EmploymentStatus::all();

        $members = Member::with([
            "clientWorkHistory:id,tenure_type_id,member_id,date_start,date_end",
            "clientWorkHistory.tenureType:id,tenure_type",
            "clientWorkHistory.branchWorkHistory",
            "clientWorkHistory.branchWorkHistory:id,date_start,date_end,client_work_history_id,position_id,branch_id,employment_status_id,enabled",
            "clientWorkHistory.branchWorkHistory.position:id,position_name",
            "clientWorkHistory.branchWorkHistory.employmentStatus:id,status_name,color",
            "clientWorkHistory.branchWorkHistory.branches:id,branch_name,brand_id,location_id",
            "clientWorkHistory.branchWorkHistory.branches.brand:id,brand_name,business_unit_id",
            "clientWorkHistory.branchWorkHistory.branches.brand.businessUnit:id,business_unit_name",
            "clientWorkHistory.branchWorkHistory.branches.location.city:id,city_name",
            "clientWorkHistory.branchWorkHistory.branches.location.city.region:id,region_name"
            ])
            ->select([
                "members.id",
                "members.new_member_id",
                "members.first_name",
                "members.last_name",
                "members.middle_name",
                "members.data_completion",
                "members.last_modified_by",
                "members.updated_at",
                "existing_member_id",
                "updated_at as update_details"
            ])
            ->get();

        $latest = [];
        foreach ($members as $member) {
            $result["id"] = $member->id;
            $result["name"] = $member->first_name . " " . $member->middle_name . " " . $member->last_name;
            $result["member_id"] = str_pad($member->new_member_id, 6, 0, STR_PAD_LEFT);
            $result["complete"] = $member->data_completion;
            $result["last_modified_by"] = $member->last_modified_by;
            $result["updated_at"] = Carbon::parse($member->updated_at)->toFormattedDateString();

            // if currently under a client
            $member_cwh = $member->clientWorkHistory->sortByDesc("id")->values();
            
            // if currently deployed in a specific branch
            if ($member_cwh->isNotEmpty()) {
                if (!is_null($member_cwh->first()["date_end"])) {
                    $is_date_valid = Carbon::parse($member_cwh->first()["date_end"])->isFuture();
                } else {
                    $is_date_valid = true;
                }

                if ($is_date_valid) {
                    $current_client = $member_cwh->first();
                    $cwh_date_start = Carbon::parse($current_client["date_start"]);
    
                    $bwh = $member_cwh->first()->branchWorkHistory->filter(function ($value, $key) {
                        return is_null($value->date_end) || Carbon::parse($value->date_start)->lte(Carbon::today());
                    })->values()->sortByDesc("date_end")->values()->first();

                    if (is_null($bwh)) {
                        // if under a client but not yet deployed
                        $result["branch"] = null;
                        $result["brand_id"] = null;
                        $result["date_end"] = null;
                        $result["brand"] = null;
                        $result["business_unit"] = null;
                        $result["location_id"] = null;
                        $result["location"] = null;
                        $result["city_id"] = null;
                        $result["city"] = null;
                        $result["position_id"] = null;
                        $result["position"] = null;
                        $result["tenure_id"] = null;
                        $result["tenure"] = null;
                        $result["hiring_date"] = null;
                        $result['time_diff'] =null;
                        $result["status"] = "Floating";
                        $result["status_id"] = null;
                        $result["status"] = "Transition";
                        $result["color"] = null;
                    } else {
                        $result["status"] = $bwh["employmentStatus"]["status_name"];
                        $result["status_id"] = $bwh["employmentStatus"]["id"];
                        $result["color"] = $bwh["employmentStatus"]["color"];
                    }
    
                    $result["branch"] = $bwh["branches"]["branch_name"];
                    $result["brand_id"] = $bwh["branches"]["brand"]["id"];
                    $result["brand"] = $bwh["branches"]["brand"]["brand_name"];
                    $result["business_unit"] = $bwh["branches"]["brand"]["businessUnit"]["business_unit_name"];
                    $result["location_id"] = $bwh["branches"]["location"]["id"];
                    $result["location"] = $bwh["branches"]["location"]["location_name"];
                    $result["city_id"] = $bwh["branches"]["location"]["city"]["id"];
                    $result["city"] = $bwh["branches"]["location"]["city"]["city_name"];
                    $result["position_id"] = $bwh["position"]["id"];
                    $result["position"] = $bwh["position"]["position_name"];
                    $result["tenure_id"] = $member_cwh->first()["tenureType"]["id"];
                    $result["tenure"] = $member_cwh->first()["tenureType"]["tenure_type"];
                    $result["hiring_date"] = $cwh_date_start->toFormattedDateString();
                    $result['time_diff'] = $cwh_date_start->diffForHumans();
                } else {
                    $result["branch"] = null;
                    $result["brand_id"] = null;
                    $result["date_end"] = null;
                    $result["brand"] = null;
                    $result["business_unit"] = null;
                    $result["location_id"] = null;
                    $result["location"] = null;
                    $result["city_id"] = null;
                    $result["city"] = null;
                    $result["position_id"] = null;
                    $result["position"] = null;
                    $result["tenure_id"] = null;
                    $result["tenure"] = null;
                    $result["hiring_date"] = null;
                    $result['time_diff'] =null;
                    $result["status"] = "Floating";
                    $result["status_id"] = $employee_status->where("status_name", "Floating")->first()->id;
                    $result["color"] = null;
                    $color = $employee_status->where("status_name", "Floating")->first()->color;
                    $result["color"] = $color;
                }
            } else {
                $result["branch"] = null;
                $result["brand_id"] = null;
                $result["date_end"] = null;
                $result["brand"] = null;
                $result["business_unit"] = null;
                $result["location_id"] = null;
                $result["location"] = null;
                $result["city_id"] = null;
                $result["city"] = null;
                $result["position_id"] = null;
                $result["position"] = null;
                $result["tenure_id"] = null;
                $result["tenure"] = null;
                $result["hiring_date"] = null;
                $result['time_diff'] =null;
                $result["status"] = "Floating";
                $result["status_id"] = $employee_status->where("status_name", "Floating")->first()->id;
                $result["color"] = null;
                $color = $employee_status->where("status_name", "Floating")->first()->color;
                $result["color"] = $color;
            }

            $latest[] = $result;
        }

        return collect($latest)->sortBy("member_id")->values();
    }

    /**
     * Update the specified member in database.
     *
     * @param array $attributes
     * @return string'Success'
     */
    public function updateMember($attributes = [])
    {
        $relations = collect([
            'mobile_number',
            'telephone_number',
            'references_data',
            'school_data',
            'family_data',
            'emergency_data',
            'emp_history_data'
        ]);

        $this->enabled = 1;
        $this->fill($attributes);
        $this->birthdate = date('Y-m-d H:i:s', strtotime($attributes['birthdate']));
        $this->save();

        $new_relations = $relations->filter(function ($item) use ($attributes) {
            return array_key_exists($item, $attributes) && count($attributes[$item]) !== 0;
        });

        foreach ($new_relations as $relation) {
            $this->updateMultiple($attributes[$relation], $relation);
        }

        return true;
    }

    /**
     * Updates or Creates data related to member includes School, Reference, Family, Emergency and History
     *
     * @param array $data
     * @param string $class
     * @return 'Success'
     */
    private function updateMultiple(array $data, $class)
    {
        switch ($class) {
            case 'mobile_number':
                $model = new MobileNumber;
                $model_relation = $this->mobileNumbers();
                $from_db = $model_relation->get(['id']);
                $attributes = ['number'];
                break;
            case 'telephone_number':
                $model = new TelephoneNumber;
                $model_relation = $this->telephoneNumbers();
                $from_db = $model_relation->get(['id']);
                $attributes = ['number'];
                break;
            case 'references_data':
                $model = new Reference;
                $model_relation = $this->references();
                $from_db = $model_relation->get(['id']);
                $attributes = ['name', 'address', 'company', 'position', 'contact'];
                break;
            case 'school_data':
                $model = new School;
                $model_relation = $this->schools();
                $from_db = $model_relation->get(['id']);
                $attributes = ['school_type', 'school_name', 'degree'];
                break;
            case 'family_data':
                $model = new FamilyMember;
                $model_relation = $this->familyMembers();
                $from_db = $model_relation->get(['id']);
                $attributes = ['name', 'family_type', 'age', 'occupation'];
                break;
            case 'emergency_data':
                $model = new EmergencyContact;
                $model_relation = $this->emergencyContacts();
                $from_db = $model_relation->get(['id']);
                $attributes = ['name', 'relationship', 'address', 'contact'];
                break;
            case 'emp_history_data':
                $model = new EmploymentHistory;
                $model_relation = $this->employmentHistories();
                $from_db = $model_relation->get(['id']);
                $attributes = ['company_name', 'position', 'reason_for_leaving'];
                break;
        }

        $ids_from_db = array_map(function ($value) {
            return $value->id;
        }, json_decode(json_encode($from_db)));

        // [ADD || UPDATE]
        foreach ($data as $key => $info) {
            $id = array_key_exists('id', $info) ? $info['id'] : '';
            $model_relation->updateOrCreate(
                ['id' => $id],
                array_map(function ($value) {
                    return $attributes = $value ? ucfirst($value) : '';
                }, $info)
            );
        }

        // [DELETE]
        // remove empty ids && return only ids from input data
        $data_id = array_map(
            function ($value) {
                return $value['id'];
            },
            array_filter($data, function ($value) {
                if (array_key_exists('id', $value)) {
                    return ($value['id'] != '') && $value;
                }
            })
        );

        foreach ($ids_from_db as $key => $value) {
            if (!in_array($value, $data_id)) {
                $to_delete = $model::find($value);
                $to_delete->delete();
            }
        }

        return 'Success!';
    }

    /**
     * Stores a member in the database
     *
     * @param array $attributes
     * @return object Member
     */
    public function create($attributes = [])
    {
        $relations = [
            'mobile_number',
            'telephone_number',
            'references_data',
            'school_data',
            'family_data',
            'emergency_data',
            'emp_history_data'
        ];
        $gov_numbers = ["sss_num", "pag_ibig_num", "philhealth_num"];
        
        $attributes["first_name"] = ucfirst($attributes["first_name"]);
        $attributes["last_name"] = ucfirst($attributes["last_name"]);

        $this->validateIdentity($attributes);
    
        foreach ($gov_numbers as $number) {
            if (array_key_exists($number, $attributes)) {
                if (!is_null($attributes[$number])) {
                    $this->validateGovNumbers($attributes);
                }
            }
        }
        
        $this->new_member_id = $this->max("new_member_id") + 1;
        $this->enabled = 1;
        $this->data_completion = 1;
        $this->fill($attributes);
        $this->birthdate = date('Y-m-d H:i:s', strtotime($this->birthdate));
        $this->save();

        foreach ($relations as $relation) {
            $this->saveRelation($attributes[$relation], $relation);
        }

        return $this;
    }

    private function validateIdentity($attributes)
    {
        $validator = Validator::make([], []);
        $birthdate = date("Y-m-d", strtotime($attributes["birthdate"]));
        $current = $attributes["first_name"] . " " . $attributes["last_name"] . " " . $birthdate;

        $members_validate_unique = Member::select(
            \DB::raw("CONCAT(first_name,' ', last_name, ' ', DATE(birthdate)) as name")
        )
        ->get()
        ->map(function ($item) {
            return $item->name;
        })
        ->filter(function ($item) use ($current) {
            return strtoupper($item) === strtoupper($current);
        })
        ->values()
        ->count();

        if ($members_validate_unique > 0) {
            $validator->errors()->add('first_name', 'Member has the same name and birthdate.');
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    private function validateGovNumbers($attributes)
    {
        $validator = Validator::make($attributes, [
            "sss_num" => "unique:members",
            "pag_ibig_num" => "unique:members",
            "philhealth_num" => "unique:members",
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    /**
     * Saves relationships of member on create
     *
     * @param array $data
     * @param string $class
     *
     */
    private function saveRelation(array $data, string $class)
    {
        $newData = [];
        $attributes = [];

        foreach ($data as $value) {
            switch ($class) {
                case 'mobile_number':
                    $object = new MobileNumber;
                    $attributes = ['number'];
                    break;
                case 'telephone_number':
                    $object = new TelephoneNumber;
                    $attributes = ['number'];
                    break;
                case 'school_data':
                    $object = new School;
                    $attributes = ['school_type', 'school_name', 'degree'];
                    break;
                case 'emp_history_data':
                    $object = new EmploymentHistory;
                    $attributes = ['company_name', 'position', 'reason_for_leaving'];
                    break;
                case 'emergency_data':
                    $object = new EmergencyContact;
                    $attributes = ['name', 'relationship', 'address', 'contact'];
                    break;
                case 'family_data':
                    $object = new FamilyMember;
                    $attributes = ['name', 'family_type', 'age', 'occupation'];
                    break;
                case 'references_data':
                    $object = new Reference;
                    $attributes = ['name', 'address', 'company', 'position', 'contact'];
                    break;
            }

            foreach ($attributes as $attribute) {
                $object->$attribute = array_key_exists($attribute, $value) ? ucfirst($value[$attribute]) : '';
            }

            if (array_key_exists('started_at', $value)) {
                // original
                // $object->started_at = date('Y-m-d H:i:s', strtotime($value['started_at']));
                // $object->ended_at = date('Y-m-d H:i:s', strtotime($value['ended_at']));

                // modified
                $object->started_at = $value['started_at'];
                $object->ended_at = $value['ended_at'];
            }

            array_push($newData, $object);
        }


        switch ($class) {
            case 'school_data':
                $this->schools()->saveMany($newData);
                break;
            case 'family_data':
                $this->familyMembers()->saveMany($newData);
                break;
            case 'references_data':
                $this->references()->saveMany($newData);
                break;
            case 'emp_history_data':
                $this->employmentHistories()->saveMany($newData);
                break;
            case 'emergency_data':
                $this->emergencyContacts()->saveMany($newData);
                break;
            case 'mobile_number':
                $this->mobileNumbers()->saveMany($newData);
                break;
            case 'telephone_number':
                $this->telephoneNumbers()->saveMany($newData);
                break;
        }
    }

    public static function memberWorkHistory($id)
    {
        $result = BranchWorkHistory::with("disciplinaryActions")->get();
        $result = Member::with([
            "branchWorkHistory" => function ($q) {
                $q->join("branches as br", "br.id", "branch_id");
                $q->join("positions as p", "p.id", "position_id");
                $q->join("brands as b", "b.id", "brand_id");
                $q->join("locations as l", "l.id", "location_id");
                $q->join("cities as c", "c.id", "city_id");
                $q->join("clients as cl", "cl.id", "client_work_histories.client_id");
                $q->join("employment_statuses as es", "es.id", "employment_status_id");
                $q->select(
                    "branch_work_histories.id",
                    "client_work_histories.id as cwh_id",
                    "client_work_histories.client_id as client_id",
                    "client_name as client",
                    "code as client_code",
                    "position_id as position_id",
                    "position_name as position",
                    "brand_id as brand_id",
                    "brand_name as brand",
                    "branch_id as branch_id",
                    "branch_name as branch",
                    "employment_status_id as employment_status_id",
                    "status_name as employment_status_name",
                    "color as employment_status_color",
                    "city_name as city",
                    "client_work_histories.date_start as cwh_date_start",
                    "client_work_histories.date_end as cwh_date_end",
                    "branch_work_histories.date_start as bwh_date_start",
                    "branch_work_histories.date_end as bwh_date_end"
                );
            },
            "branchWorkHistory.disciplinaryActions"
        ])
        ->where("id", $id)
        ->first()
        ->branchWorkHistory;

        /**
         * DA status
         * 0 = NA, 1 = Pending, 2 = Resolved
         */

        return $result->groupBy("cwh_id")->values()->map(function ($item, $key) {
            $value = $item->first();
            
            $cwh_date_start = Carbon::parse($value->cwh_date_start);
            $cwh_date_end = is_null($value->cwh_date_end) ? "Present" : Carbon::parse($value->cwh_date_end);
            $duration = is_null($value->cwh_date_end)
                            ? $cwh_date_start->diffForHumans()
                            : $cwh_date_start->diff($cwh_date_end)->format("%y" != 0 ? "%y years, %m months %d days" : "%m months and %d days");

            return [
                "id" => $value->cwh_id,
                "client_id" => $value->client_id,
                "client_name" => ucfirst($value->client),
                "client_code" => strtoupper($value->client_code),
                "duration" => $duration,
                "date_start" => $cwh_date_start->toFormattedDateString(),
                "date_end" => is_null($value->cwh_date_end) ? "Present" : $cwh_date_end->toFormattedDateString(),
                "positions" => $item->map(function ($value, $index) {
                    $date_start = Carbon::parse($value->bwh_date_start);
                    $date_end = is_null($value->bwh_date_end) ? "Present" : Carbon::parse($value->bwh_date_end);
                    $duration = is_null($value->bwh_date_end)
                    ? $date_start->diffForHumans()
                    : $date_start->diff($date_end)->format("%y" != 0 ? "%y years, %m months %d days" : "%m months and %d days");

                    $da = $value->disciplinaryActions->filter(function ($item) {
                        return $item;
                    })->values()->count();

                    return [
                        "id" => $value->id,
                        "client_id" => $value->client_id,
                        "position_id" => $value->position_id,
                        "position" => $value->position,
                        "branch_id" => $value->branch_id,
                        "branch" => $value->branch,
                        "brand_id" => $value->brand_id,
                        "brand" => $value->brand,
                        "employment_status_id" => $value->employment_status_id,
                        "status_name" => $value->employment_status_name,
                        "color" => $value->employment_status_color,
                        "duration" => $duration,
                        "date_start" => $date_start->toFormattedDateString(),
                        "hasEnded" => is_string($date_end) ? false : $date_end->lte(Carbon::today()),
                        "date_end" => is_string($date_end) ? "Present" : $date_end->toFormattedDateString(),
                        "disciplinary_actions" => [
                            "data" => $value->disciplinaryActions,
                            "resolved" => $value->disciplinaryActions->filter(function ($item) {
                                return $item['status'] === 1;
                            })->values()->count(),
                            "ongoing" => $value->disciplinaryActions->filter(function ($item) {
                                return $item['status'] === 0;
                            })->values()->count(),
                        ]
                    ];
                })->sortByDesc("id")->values()];
        })->sortByDesc("date_start")->values();
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public static function getDocuments($id)
    {
        $result = Member::find($id);
        return $result->documents->map(function ($item) {
            return [
                "id" => $item->id,
                "document_name" => $item->document_name,
                "type" => $item->documentType->type_name,
                "file_url" => url("/") . "/download-document/" . $item->path,
                "created_at" => Carbon::parse($item->created_at)->toFormattedDateString()
            ];
        });
    }

    public static function getCountPerEmploymentStatus()
    {
        $members = Member::with(['latestClientWorkHistory'])->get();
        return $members;
    }
}

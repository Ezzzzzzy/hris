<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\ClientWorkHistory;
use App\Models\EmploymentStatus;
use App\Models\DisciplinaryAction;
use App\Models\Location;
use App\Models\Position;

class BranchWorkHistory extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'enabled',
        'date_start',
        'date_end',
        'position_id',
        'branch_id',
        'status',
        'client_work_history_id',
        'employment_status_id',
        'reason_for_leaving_remarks',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function reasonsForLeaving()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }

    public function clientWorkHistory()
    {
        return $this->belongsTo(ClientWorkHistory::class);
    }

    public function disciplinaryActions()
    {
        return $this->hasMany(DisciplinaryAction::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class, "branch_id");
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    
    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class);
    }

    /**
     * Stores a new BranchWorkHistory associating a newly created ClientWorkHistory associated with a MemberId
     *
     * @param array $attributes
     * @param in $member_id
     * @return boolean
     */
    public static function deployMember($attributes = [], $member_id)
    {
        $branchWorkHistory = new static;
        $clientWorkHistory = new ClientWorkHistory;

        $member = Member::findOrFail($member_id);
        $client = Client::findOrFail($attributes['client_id']);

        // filler
        $tenureType = TenureType::find(1);
        $clientWorkHistory->status = 1;
        $branchWorkHistory->status = 1;
        $clientWorkHistory->last_modified_by = $attributes["last_modified_by"];
        $branchWorkHistory->last_modified_by = $attributes["last_modified_by"];
        $branchWorkHistory->enabled = 1;

        $branch = Branch::findOrFail($attributes['branch_id']);
        $position = Position::findOrFail($attributes['position_id']);
        $employment_status = EmploymentStatus::findOrFail($attributes['employment_status_id']);

        $clientWorkHistory->tenureType()->associate($tenureType);
        $clientWorkHistory->member()->associate($member);
        $clientWorkHistory->client()->associate($client);
        $clientWorkHistory->fill($attributes);
        $clientWorkHistory->save();

        $branchWorkHistory->clientWorkHistory()->associate($clientWorkHistory);
        $branchWorkHistory->branches()->associate($branch);
        $branchWorkHistory->position()->associate($position);
        $branchWorkHistory->employmentStatus()->associate($employment_status);
        $branchWorkHistory->fill($attributes);

        if ($member->save() && $branchWorkHistory->save()) {
            return $branchWorkHistory;
        }

        return false;
    }

    /**
     * Updates a record in branch_work_histories of a specific member
     *
     * @param array $attributes
     * @return boolean
     */
    public static function updateStatusHistory($attributes = [])
    {
        $deployment = new static;

        // [ADD || UPDATE]
        foreach ($attributes['history'] as $key => $history) {
            $history['enabled'] = 1;
            $history['status'] = 1;
            $history['branch_id'] = $attributes['branch_id'];
            $history['client_work_history_id'] = $attributes['client_work_history_id'];
            $history['position_id'] = $attributes['position_id'];

            $id = array_key_exists('id', $history) ? $history['id'] : '';
            $deployment->updateOrCreate(['id' => $id], $history);
        }

        return $deployment;
    }

    public function endDeployment($attributes = [], $member_id, $bwh_id)
    {

        $reason = Reason::findOrFail($attributes['reason_id']);
        $employment_status = EmploymentStatus::findOrFail($attributes['employment_status_id']);
        $clientWorkHistory = ClientWorkHistory::findOrFail($bwh_id);

        $member = Member::findOrFail($member_id);
        $bwh_members = $member->branchWorkHistory;
        
        $bwh_members_id = $bwh_members->map(function($member){
            return $member->id;
        });

        if (!in_array($bwh_id, $bwh_members_id)) {
            return ['message' => 'Member does not contain bwh id ' . $bwh_id];
        }

        // if ($reason->reason !== 'Transfer of Branch') {
        //     $clientWorkHistory->date_end = $attributes['date_end'];
        // }
        

        $this->employmentStatus()->associate($employment_status);
        $this->reasonsForLeaving()->associate($reason);
        $this->fill($attributes);

        return $this->save() ? $this : false;
    }

    public static function reportsData()
    {
        $members = BranchWorkHistory::with([
            'position:id,position_name',
            'employmentStatus:id,status_name',
            'branches:id,branch_name,brand_id,location_id',
            'branches.location:id,location_name,city_id',
            'branches.location.city:id,city_name,region_id',
            'branches.location.city.region:id,region_name',
            'branches.brand:id,brand_name,business_unit_id',
            'branches.brand.businessUnit:id,business_unit_name,code,client_id',
            'branches.brand.businessUnit.client:id,client_name,code',
            'clientWorkHistory:id,member_id,date_start,date_end,client_id,tenure_type_id',
            'clientWorkHistory.tenureType:id,tenure_type',
            'clientWorkHistory.member:id,existing_member_id,first_name,middle_name,last_name,data_completion,email_address,fb_address,gender,sss_num,tin,philhealth_num,birthdate,pag_ibig_num,present_address,present_address_city,height,civil_status,ATM,maternity_leave,rate',
            'clientWorkHistory.member.documents',
            'clientWorkHistory.member.mobileNumbers',
            'clientWorkHistory.member.telephoneNumbers',
            'clientWorkHistory.member.schools',
            'reasonsForLeaving'
        ])
       ->get();

        $result = $members->map(function ($item, $key) {
            $member_mobile_numbers = $item['clientWorkHistory']['member']['mobileNumbers'];
            $member_telephone_numbers = $item['clientWorkHistory']['member']['telephoneNumbers'];
            $member_documents = $item['clientWorkHistory']['member']['documents'];
            $member_schools = $item['clientWorkHistory']['schools'];
            $telephone = $member_telephone_numbers ? $member_telephone_numbers : collect([]);
            $mobile =  $member_mobile_numbers ? $member_mobile_numbers : collect([]);
            $documents =  $member_documents ? $member_documents : collect([]);
            $schools = $member_schools ? $member_schools : collect([]);

            $schools = $schools->map(function($item){
                return $item["school_type"];
            });
            
            $documents = $documents->map(function($item){
                return $item['document_type_id'];
            });

            $mobile_numbers = $mobile->map(function ($item) {
                return $item['number'];
            });

            $telephone_numbers = $telephone->map(function ($item) {
                return $item['number'];
            });

            return [
                'bwh_id' => $item['id'],
                'start_date' => $item['clientWorkHistory']['date_start'],
                'end_date' => $item['clientWorkHistory']['date_end'],
                'client_id' => $item['branches']['brand']['businessUnit']['client']['id'],
                'client_code' => $item['branches']['brand']['businessUnit']['client']['code'],
                'client_name' => $item['branches']['brand']['businessUnit']['client']['client_name'],
                'business_unit_id' => $item['branches']['brand']['businessUnit']['id'],
                'business_unit_name' => $item['branches']['brand']['businessUnit']['business_unit_name'],
                'business_unit_code' => $item['branches']['brand']['businessUnit']['code'],
                'brand_id' => $item['branches']['brand']['id'],
                'brand_name' => $item['branches']['brand']['brand_name'],
                'branch_id' => $item['branches']['id'],
                'branch_name' => $item['branches']['branch_name'],
                'region_id' => $item['branches']['location']['city']['region']['id'],
                'region_name' => $item['branches']['location']['city']['region']['region_name'],
                'city_id' => $item['branches']['location']['city']['id'],
                'city_name' => $item['branches']['location']['city']['city_name'],
                'location_id' => $item['branches']['location']['id'],
                'location_name' => $item['branches']['location']['location_name'],
                'position_id' => $item['position']['id'],
                'position_name' => $item['position']['position_name'],
                'employment_status_id' => $item['employmentStatus']['id'],
                'employment_status_name' => $item['employmentStatus']['status_name'],
                'tenure' => $item['clientWorkHistory']['tenureType']['tenure_type'],
                'first_name' => $item['clientWorkHistory']['member']['first_name'],
                'middle_name' => $item['clientWorkHistory']['member']['middle_name'],
                'last_name' => $item['clientWorkHistory']['member']['last_name'],
                'member_id' => $item['clientWorkHistory']['member']['id'],
                'employee_id' => $item['clientWorkHistory']['member']['existing_member_id'],
                'gender' => $item['clientWorkHistory']['member']['gender'],
                'height' => $item['clientWorkHistory']['member']['height'],
                'civil_status' => $item['clientWorkHistory']['member']['civil_status'],
                'birthdate' => $item['clientWorkHistory']['member']['birthdate'],
                'data_completion' => $item['clientWorkHistory']['member']['data_completion'],
                'fb_address' => $item['clientWorkHistory']['member']['fb_address'],
                'email' => $item['clientWorkHistory']['member']['email_address'],
                'requirement_type' => $documents,
                'sss_num' => $item['clientWorkHistory']['member']['sss_num'],
                'tin_num' => $item['clientWorkHistory']['member']['tin'],
                'philhealth_num' => $item['clientWorkHistory']['member']['philhealth_num'],
                'pagibig_num' => $item['clientWorkHistory']['member']['pag_ibig_num'],
                'address' => $item['clientWorkHistory']['member']['present_address'],
                'address_city' => $item['clientWorkHistory']['member']['present_address_city'],
                'reason' => $item["reasonsForLeaving"]["reason"],
                'atm' => $item['clientWorkHistory']['member']['ATM'],
                'maternity_leave' => $item['clientWorkHistory']['member']['maternity_leave'],
                'rate' => $item['clientWorkHistory']['member']['rate'],
                'schools' => $schools,
                'mobile_numbers' => $mobile_numbers ? $mobile_numbers : [],
                'telephone_numbers' => $telephone_numbers ? $telephone_numbers : [],
            ];
        });

        return $result;
    }
}

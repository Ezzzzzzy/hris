<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'existing_member_id' => $this->existing_member_id,
            'new_member_id' => $this->new_member_id,
            'nickname' => $this->nickname,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'birthplace' => $this->birthplace,
            'extension_name' => $this->extension_name,
            'present_address' => $this->present_address,
            'present_address_city' => $this->present_address_city,
            'permanent_address' => $this->permanent_address,
            'permanent_address_city' => $this->permanent_address_city,
            'atm' => $this->ATM,
            'maternity_leave' => $this->maternity_leave,
            'rate' => $this->rate,
            'tin' => $this->tin,
            'height' => $this->height,
            'weight' => $this->weight,
            'sss_num' => $this->sss_num,
            'fb_address' => $this->fb_address,
            'civil_status' => $this->civil_status,
            'pag_ibig_num' => $this->pag_ibig_num,
            'email_address' => $this->email_address,
            'philhealth_num' => $this->philhealth_num,
            'last_modified_by' => $this->last_modified_by,
            'gender' => $this->gender,
            'birthdate' => Carbon::parse($this->birthdate)->toFormattedDateString(),
            'data_completion' => $this->data_completion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'present_city' => $this->presentCities['address_city_name'],
            'permanent_city' => $this->permanentCities['address_city_name'],
            'mobile_number' => $this->mobileNumbers->toArray(),
            'telephone_number' => $this->telephoneNumbers->toArray(),
            'enabled' => $this->enabled,
            'schools' => $this->schools,
            'emp_history_data' => $this->employmentHistories,
            'family_data' => $this->familyMembers,
            'emergency_data' => $this->emergencyContacts,
            'references_data' => $this->references,
            $this->mergeWhen($this->clientWorkHistory->last(), [
                'status_name' => $this->clientWorkHistory->last()
            ]),
        ];
    }
}

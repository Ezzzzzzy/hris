<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class BusinessUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $last_modified = new Carbon($this->updated_at);

        return [
            "id" => $this->id,
            "business_unit_name" => $this->business_unit_name,
            "brands_count" => $this->brands->count(),
            "branches_count" => $this->branches->count(),
            // modified
            // To Do
            // [ ] check whether currentMembers or members
            // "members_count" => $this->client->currentMembers->count(),
            "members_count" => $this->client->members->count(),

            "client_id" => $this->client_id,
            "code" => $this->code,
            "enabled" => $this->enabled,
            "last_modified_by" => $this->last_modified_by,
            "last_modified" =>  $last_modified->toFormattedDateString()
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class BranchResource extends JsonResource
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
            "region_id" => $this->location->city->region->id,
            "region" => $this->location->city->region->region_name,
            "city_id" => $this->location->city->id,
            "city" => $this->location->city->city_name,
            "brand_id" => $this->brand->id,
            "brand" => $this->brand->brand_name,
            "branch_name" => $this->branch_name,
            "location_id" => $this->location->id,
            "location" => $this->location->location_name,
            "members_count" => $this->branchWorkHistoryNew->count(),
            "enabled" => $this->enabled,
            "last_modified" => $last_modified->toFormattedDateString()
        ];
    }
}

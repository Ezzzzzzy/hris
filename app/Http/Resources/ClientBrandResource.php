<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientBrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $updated_at = new Carbon($this->updated_at);
        return [
            'id' => $this->id,
            'brand_name' => $this->brand_name,

            'client_id' => $this->client->id,
            'client_name' => $this->client->client_name,
            'code' => $this->client->code,

            'business_unit_code' => $this->businessUnit ? $this->businessUnit->code : "N/A",

            'branches_count' => $this->branches->count(),
            'cities_count' => $this->cities->count(),
            'members_count' => $this->branchWorKhistory->count(),
            'regions_count' => $this->regions->count(),

            'enabled' => $this->enabled,
            'last_modified' => $updated_at->toFormattedDateString(),
            'last_modified_by' => $this->last_modified_by,
            'business_unit_id' => $this->BusinessUnit ? $this->BusinessUnit->id : null,
            'business_unit' => $this->BusinessUnit ? $this->BusinessUnit->code : null,
        ];
    }
}

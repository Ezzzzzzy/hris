<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ClientResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->client_name,
            'contract_name' => $this->contract_name,
            'code' => $this->code,
            'enabled' => $this->resource->enabled,
            'last_modified' => $last_modified->toFormattedDateString(),
            'last_modified_by' => $this->last_modified_by,
            
            // modified
            // 'business_units_count' => $this->businessUnits->count(),
            // 'brands_count' => $this->brandsWithoutBusinessUnit->count(),
            // 'branches_count' => $this->branches->count(),
            // 'members_count' => $this->currentMembers->count(),
            
            // original
            // 'brands_count' => $this->brands_count, //+ $this->brands_without_business_unit_count,
            'members_count' => $this->members_count,
            'brands_count' => $this->brands_without_business_unit_count,
            'business_unit_count' => $this->business_units_count,
            'branches_count' => $this->branches_count + $this->branchWithouthBU_count,
        ];
    }
}

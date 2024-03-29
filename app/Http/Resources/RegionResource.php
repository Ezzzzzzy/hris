<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'region_name' => $this->region_name,
            'order' => $this->order,
            'enabled' => $this->enabled,
            'last_modified_by' => $this->last_modified_by,
        ];
    }
}

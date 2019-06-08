<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'city_name' => $this->city_name,
            'enabled' => $this->enabled,
            'last_modified_by' => $this->last_modified_by,
            'region_id' => $this->region_id,
            'region' => $this->when(!is_null($this->region), $this->region['region_name'])
        ];
    }
}

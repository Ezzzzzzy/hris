<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'location_name' => $this->location_name,
            'enabled' => $this->enabled,
            'last_modified_by' => $this->last_modified_by,
            $this->mergeWhen($this->city['city_name'], [
                'city_id' => $this->city_id,
                'city' => $this->city['city_name'],
                'region' => $this->city['region']['region_name']
            ]),
        ];
    }
}

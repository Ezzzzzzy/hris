<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenureTypeResource extends JsonResource
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
            'tenure_type' => $this->tenure_type,
            'month_start_range' => $this->month_start_range,
            'month_end_range' => $this->month_end_range,
            'range' => $this->month_start_range." mos - ".$this->month_end_range." mos",
            'enabled' => $this->enabled
        ];

    }
}

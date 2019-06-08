<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReasonResource extends JsonResource
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
            'reason' => $this->reason,
            'remarks' => $this->remarks,
            'order' => $this->order,
            'enabled' => $this->enabled,
            'last_modified_by' => $this->last_modified_by,
        ];
    }
}

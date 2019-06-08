<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
            'position_name' => $this->position_name,
            'order' => $this->order,
            'enabled' => $this->enabled,
            'last_modified_by' => $this->last_modified_by
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param \Illuminate\Http\Request
     * @param \Illuminate\Http\Response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('Content-Type', 'application/json');
    }
}

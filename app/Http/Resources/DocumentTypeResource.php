<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentTypeResource extends JsonResource
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
            'type_name' => $this->type_name,
            'document_type' => $this->document_type,
            'order' => $this->order,
            'enabled' => $this->enabled,
            'last_modified_by' => $this->last_modified_by
        ];
    }
}

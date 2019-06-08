<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $created_at = Carbon::parse($this->created_at)->toFormattedDateString();

        return [
            'id' => $this->id,
            'date' => $created_at,
            'title' => $this->title,
            'type' => (strtoupper($this->type) === 'ML') ? 'ML' : 'HC' ,
            // 'template_no' => $this->template_no,
            'generated_by' => $this->user->name
        ];
    }
}

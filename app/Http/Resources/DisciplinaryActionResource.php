<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DisciplinaryActionResource extends JsonResource
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
            "id" => $this->id,
            "date_of_incident" => Carbon::parse($this->date_of_incident)->toFormattedDateString(),
            "date_of_notice_to_explain" => Carbon::parse($this->date_of_notice_to_explain)->toFormattedDateString(),
            "date_of_decision" => Carbon::parse($this->date_of_decision)->toFormattedDateString(),
            "incident_report" => $this->incident_report,
            "decision" => $this->decision,
            "status" => ($this->status === 0) ? "Ongoing" : "Resolved"
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Brand;

class DeploymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cwh_date_end = $this->clientWorkHistory->date_end;
        $date_end = $cwh_date_end ? Carbon::parse($cwh_date_end)->toFormattedDateString() : null;
        $date_start = Carbon::parse($this->date_start)->toFormattedDateString();
        $brand_name = Brand::find($this->branches->brand_id)->brand_name;

        // $this->position,
        $position = [
            "id" => $this->position->id,
            "date_start" => $date_start,
            "date_start" => $date_end,
            "position" => $this->position->position_name,
            "branch" => $this->branches->branch_name,
            "brand" => $brand_name,
        ];

        // "position": "Concierge",
        // "branch": "Jollibee - D'Amore Summit",
        // "brand": "Test Brand Update",
        // "duration": "1 years and 0 months",
        // "date_start": "Sep 24, 2017",
        // "date_end": "Sep 28, 2018",
        // "disciplinary_actions": "Pending DA"



        return [
            'id' => $this->client_work_history_id,
            'client_name' => $this->clientWorkHistory->client->client_name,
            'client_code' => $this->clientWorkHistory->client->code,
            'duration' => 'add duration here',
            'date_end' => $date_end,
            'positions' => $position
        ];
        // return parent::toArray($request);
    }
}

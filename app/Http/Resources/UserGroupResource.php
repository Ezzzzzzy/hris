<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Client;

class UserGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $updated_at = Carbon::parse($this->update_at)->toFormattedDateString();
        $total_client_count = Client::count();
        if ($this->clients_count > 0) {
            $client =($this->clients_count === $total_client_count) ? 'All' : 'Specific';
        } else {
            $client = 'None';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'clients' => $client,
            'members' => $this->users_count,
            'status' => $this->status,
            'last_modified_at' => $updated_at,
            // 'last_modified_by' => $this->enabled
        ];
    }
}

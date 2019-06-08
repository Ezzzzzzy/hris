<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleModel;
// use Spatie\Permission\Contracts\Role as RoleContracts;
use App\Models\RoleHasClient;
use App\Models\Client;
use App\User;
use Carbon\Carbon;

class Role extends RoleModel
{
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'role_has_clients', 'role_id', 'client_id');
    }

    public static function getUserGroups()
    {
        $result = Role::withCount(['users', 'clients'])->get();
        
        return $result->map(function ($item, $key) {
            $updated_at = Carbon::parse($item['update_at'])->toFormattedDateString();

            $total_client_count = Client::count();

            if ($item['clients_count'] > 0) {
                $client =($item['clients_count'] === $total_client_count) ? 'All' : 'Specific';
            } else {
                $client = 'None';
            }
    
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'clients' => $client,
                'members' => $item['users_count'],
                'status' => $item['status'],
                'last_modified_at' => $updated_at,
                // 'last_modified_by' => $this->enabled
            ];
        })->values();
    }
}

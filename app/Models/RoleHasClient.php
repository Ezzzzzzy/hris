<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models \{
    Role, Client
};

class RoleHasClient extends Model
{

    protected $guarded = [];

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    // public function clients()
    // {
    //     return $this->belongsTo(Client::class, 'client_id');
    // }

    public function addRoleClients($role_id, $clients = [])
    {
        $result = new RoleHasClient;
        $role = Role::findOrFail($role_id);

        foreach ($clients as $client) {
            $clientModel = Client::findOrFail($client);
            $result->role()->associate($role);
            $result->clients()->associate($clientModel);
            $result->save();
        }

        return $result;

    }

}

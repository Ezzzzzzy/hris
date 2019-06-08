<?php

use Illuminate\Database\Seeder;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Client;

use App\Models\Role as RoleModel;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("password"),
            'is_verified' => 1,
            'remember_token' => str_random(10),
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'description' => 'Admin Role',
            'status' => 1,
            'status_color' => '#00892a'
        ]);

        $role = $role->syncPermissions([
            // members
            "add_member",
            "modify_profile_of_members",
            "modify_disciplinary_actions",
            "modify_deployment",
            "view_payroll_details",
            "view_and_modify_payroll_details",
            "download_profile",
            "download_deployment_details",
            
            // clients
            // "view_clients",
            "view_add_and_modify_clients_branches_brands_bus",

            // reports
            // "member_list_with_government_ids_only",
            // "headcount_list_reports_only",
            // "member_list_reports_only",
            "reports_full_access",
            
            // users
            "system_users_full_access",

            //settings
            "system_settings",
            "bulk_upload_of_members_and_clients",
        ]);
        $user = User::where('name', 'Admin')->first();
        $user = User::findOrFail($user->id);
        $user->assignRole('Admin');
        

        $role = RoleModel::where('name', 'Admin')->first();
        $role = RoleModel::findOrFail($role->id);
        $clients = new Client;
        $clients = $clients->select('id')->get();
        $default = [];
        foreach ($clients as $client) {
            array_push($default, $client->id);
        }
        $role->clients()->sync($default);
    }
}

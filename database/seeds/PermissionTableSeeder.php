<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'add_member', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'modify_profile_of_members', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'modify_disciplinary_actions', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'modify_deployment', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'view_payroll_details', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'view_and_modify_payroll_details', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'download_profile', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'download_deployment_details', 'guard_name' => 'web', 'type'=> 'members']);
        Permission::create(['name' => 'view_clients', 'guard_name' => 'web', 'type'=> 'client_permission']);
        Permission::create(['name' => 'view_add_and_modify_clients_branches_brands_bus', 'guard_name' => 'web', 'type'=> 'client_permission']);
        Permission::create(['name' => 'member_list_with_government_ids_only', 'guard_name' => 'web', 'type'=> 'reports']);
        Permission::create(['name' => 'headcount_list_reports_only', 'guard_name' => 'web', 'type'=> 'reports']);
        Permission::create(['name' => 'member_list_reports_only', 'guard_name' => 'web', 'type'=> 'reports']);
        Permission::create(['name' => 'reports_full_access', 'guard_name' => 'web', 'type'=> 'reports']);
        Permission::create(['name' => 'system_users_full_access', 'guard_name' => 'web', 'type'=> 'users']);
        Permission::create(['name' => 'system_settings', 'guard_name' => 'web', 'type'=> 'settings']);
        Permission::create(['name' => 'bulk_upload_of_members_and_clients', 'guard_name' => 'web', 'type'=> 'settings']);
    }
}

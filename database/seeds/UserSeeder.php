<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)
            ->create()
            ->each(function($s) {
                $random_role = Role::find(random_int(\DB::table('roles')->min('id'),\DB::table('roles')->max('id')));

                $s->assignRole($random_role);
            });
    }
}

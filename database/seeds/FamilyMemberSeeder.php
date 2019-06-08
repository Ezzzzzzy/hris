<?php

use Illuminate\Database\Seeder;
use App\Models\FamilyMember;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate family_members table
        factory(FamilyMember::class, 200)->create();
    }
}

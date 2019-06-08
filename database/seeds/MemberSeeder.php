<?php

use Illuminate\Database\Seeder;
use App\Models\{Client, Member, TenureType};

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate members table
        factory(Member::class, 8000)->create();
    }
}

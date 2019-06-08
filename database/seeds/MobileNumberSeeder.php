<?php

use Illuminate\Database\Seeder;
use App\Models\MobileNumber;

class MobileNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate mobile_numbers table
        factory(MobileNumber::class, 200)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\BusinessUnit;

class BusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate business_units table
        factory(BusinessUnit::class, 8)->create();

    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\TenureType;

class TenureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate tenuretype table
        factory(TenureType::class, 4)->create();
    }
}

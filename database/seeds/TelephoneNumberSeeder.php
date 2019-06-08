<?php

use Illuminate\Database\Seeder;
use App\Models\TelephoneNumber;

class TelephoneNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate telephone_numbers table
        factory(TelephoneNumber::class, 200)->create();
    }
}

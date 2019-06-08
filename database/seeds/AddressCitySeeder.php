<?php

use Illuminate\Database\Seeder;
use App\Models\AddressCity;

class AddressCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate address_cities table
        factory(AddressCity::class, 50)->create();
    }
}

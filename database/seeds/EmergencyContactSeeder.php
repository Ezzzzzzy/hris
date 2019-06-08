<?php

use Illuminate\Database\Seeder;
use App\Models\EmergencyContact;

class EmergencyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate emergency_contacts
        factory(EmergencyContact::class, 100)->create();
    }
}

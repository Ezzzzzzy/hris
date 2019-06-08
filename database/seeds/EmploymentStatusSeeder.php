<?php

use Illuminate\Database\Seeder;
use App\Models\EmploymentStatus;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate employment_statuses table
        factory(EmploymentStatus::class, 11)->create();
    }
}

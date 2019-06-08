<?php

use Illuminate\Database\Seeder;
use App\Models\EmploymentHistory;

class EmploymentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate employment_histories table
        factory(EmploymentHistory::class, 50)->create();
    }
}

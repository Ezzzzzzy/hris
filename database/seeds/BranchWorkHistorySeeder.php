<?php

use Illuminate\Database\Seeder;
use App\Models\BranchWorkHistory;

class BranchWorkHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate branch_work_histories table
        factory(BranchWorkHistory::class, 150)->create();
    }
}

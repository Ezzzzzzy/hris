<?php

use Illuminate\Database\Seeder;
use App\Models\ClientWorkHistory;

class ClientWorkHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate client_work_history
        factory(ClientWorkHistory::class, 250)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Reason;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate reasons table
        factory(Reason::class, 13)->create();
    }
}

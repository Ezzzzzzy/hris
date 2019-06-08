<?php

use Illuminate\Database\Seeder;
use App\Models\DisciplinaryAction;

class DisciplinaryActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate disciplinary_actions table
        factory(DisciplinaryAction::class, 50)->create();
    }
}

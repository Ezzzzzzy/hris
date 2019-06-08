<?php

use Illuminate\Database\Seeder;
use App\Models\Reference;

class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate references table
        factory(Reference::class, 50)->create();
    }
}

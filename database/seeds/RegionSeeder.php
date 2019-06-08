<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Client;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $brands = Brand::all();
        // $clients = Client::all();
        
        // populate region table
        factory(Region::class, 16)->create();
        
        // attach a random region to client
        // Region::all()->each(function ($region) use ($clients){
        //     $region->clients()->syncWithoutDetaching(
        //         $clients->random(rand(0, count($clients)-1))->pluck('id')->toArray()
        //     );
        // });

        // attach a random region to brands
        // Region::all()->each(function ($region) use ($brands){
        //     $region->brands()->syncWithoutDetaching(
        //         $brands->random(rand(0, count($brands)-1))->pluck('id')->toArray()
        //     );
        // });
    }
}

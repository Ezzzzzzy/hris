<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_region', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('region_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brands');

            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_region', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['region_id']);
        });

        Schema::dropIfExists('brand_region');
    }
}

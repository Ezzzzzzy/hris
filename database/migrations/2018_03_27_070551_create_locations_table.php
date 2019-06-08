<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location_name', 60);
            $table->unsignedTinyInteger('enabled');
            $table->string('last_modified_by', 60);

            $table->unsignedBigInteger('city_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });

        Schema::dropIfExists('locations');
    }
}

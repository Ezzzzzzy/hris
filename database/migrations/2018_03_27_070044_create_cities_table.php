<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('city_name');
            $table->unsignedTinyInteger('enabled');
            $table->string('last_modified_by', 60);

            $table->unsignedBigInteger('region_id');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });

        Schema::dropIfExists('cities');
    }
}

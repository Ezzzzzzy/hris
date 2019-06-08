<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_region', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('region_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients');

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
        Schema::table('client_region', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['region_id']);
        });

        Schema::dropIfExists('client_region');
    }
}

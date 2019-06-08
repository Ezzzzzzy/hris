<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_unit_name', 60);
            $table->string('code', 60);
            $table->unsignedTinyInteger('enabled');

            $table->unsignedBigInteger('client_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_units', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });

        Schema::dropIfExists('business_units');
    }
}

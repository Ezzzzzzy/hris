<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenureTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenure_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenure_type', 60);
            $table->integer('month_start_range');
            $table->integer('month_end_range');
            $table->unsignedTinyInteger('enabled');

            $table->unsignedBigInteger('client_id');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::table('tenure_types', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });

        Schema::dropIfExists('tenure_types');
    }
}

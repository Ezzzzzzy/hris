<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('filters');

            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')
                  ->references('id')
                  ->on('reports');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_filters');
    }
}

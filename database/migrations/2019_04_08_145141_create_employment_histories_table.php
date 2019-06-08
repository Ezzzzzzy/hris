<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();

            $table->unsignedBigInteger('branch_work_history_id');
            $table->unsignedBigInteger('employment_status_id');

            $table->foreign('branch_work_history_id')
                  ->references('id')
                  ->on('branch_work_histories');

            $table->foreign('employment_status_id')
                ->references('id')
                ->on('employment_statuses');

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
        Schema::dropIfExists('employment_histories');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_work_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('reason_for_leaving_remarks')->nullable();

            $table->string('last_modified_by', 60);
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();

            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('branch_id');

            $table->unsignedBigInteger('client_work_history_id');
            // $table->unsignedBigInteger('employment_status_history_id');
            $table->unsignedBigInteger('reason_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions');

            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches');

            $table->foreign('client_work_history_id')
                  ->references('id')
                  ->on('client_work_histories');

            $table->foreign('reason_id')
                  ->references('id')
                  ->on('reasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_work_histories', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropForeign(['branch_id']);

            $table->dropForeign(['client_work_history_id']);
            $table->dropForeign(['employment_status_id']);
            $table->dropForeign(['reason_id']);
        });

        Schema::dropIfExists('branch_work_histories');
    }
}

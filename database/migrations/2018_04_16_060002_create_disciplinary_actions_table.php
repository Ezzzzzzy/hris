<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinaryActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinary_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_incident');
            $table->text('incident_report');
            $table->date('date_of_notice_to_explain');
            $table->date('date_of_explanation');
            $table->string('decision');
            $table->date('date_of_decision');
            $table->unsignedTinyInteger('status');

            $table->unsignedBigInteger('branch_work_history_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('branch_work_history_id')
                  ->references('id')
                  ->on('branch_work_histories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disciplinary_actions', function (Blueprint $table) {
            $table->dropForeign(['branch_work_history_id']);
        });
        
        Schema::dropIfExists('disciplinary_actions');
    }
}

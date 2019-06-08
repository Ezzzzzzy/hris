<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_work_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id', 60);
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();
            $table->string('last_modified_by', 60);

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('tenure_type_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients');

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members');

            $table->foreign('tenure_type_id')
                  ->references('id')
                  ->on('tenure_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_work_histories', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['member_id']);
            $table->dropForeign(['tenure_type_id']);
        });

        Schema::dropIfExists('client_work_histories');
    }
}

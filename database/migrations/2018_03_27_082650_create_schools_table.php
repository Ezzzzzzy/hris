<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_name', 60);
            $table->string('school_type', 60);
            $table->string('degree', 60)->nullable();

            $table->string('started_at');
            $table->string('ended_at');

            $table->unsignedBigInteger('member_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
        });

        Schema::dropIfExists('schools');
    }
}

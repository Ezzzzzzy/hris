<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelephoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephone_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number', 60)->nullable();

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
        Schema::table('telephone_numbers', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
        });

        Schema::dropIfExists('telephone_numbers');
    }
}
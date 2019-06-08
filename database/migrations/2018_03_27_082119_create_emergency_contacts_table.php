<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60);
            $table->string('relationship', 60);
            $table->string('address', 255);
            $table->string('contact', 60);

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
        Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
        });

        Schema::dropIfExists('emergency_contacts');
    }
}
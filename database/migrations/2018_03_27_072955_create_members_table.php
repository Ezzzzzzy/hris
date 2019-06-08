<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('existing_member_id', 60)->nullable();
            $table->integer('new_member_id');
            $table->string('nickname', 60)->nullable();
            $table->string('last_name', 60)->nullable();
            $table->string('first_name', 60)->nullable();
            $table->string('middle_name', 60)->nullable();
            $table->string('birthplace', 100)->nullable();
            $table->string('extension_name', 60)->nullable();
            $table->string('present_address', 100)->nullable();
            $table->string('present_address_city', 100)->nullable();
            $table->string('permanent_address', 100)->nullable();
            $table->string('permanent_address_city', 100)->nullable();
            $table->string('tin', 60)->nullable();
            $table->string('height', 15)->nullable();
            $table->string('weight', 15)->nullable();
            $table->string('sss_num', 60)->nullable();
            $table->string('fb_address', 60)->nullable();
            $table->string('civil_status', 60)->nullable();
            $table->string('pag_ibig_num', 60)->nullable();
            $table->string('email_address', 60)->nullable();
            $table->string('philhealth_num', 60)->nullable();
            $table->string('last_modified_by', 60)->nullable();
            $table->char('gender')->nullable();
            $table->datetime('birthdate')->nullable();
            $table->string('maternity_leave', 60)->nullable();
            $table->string('rate', 60)->nullable();
            $table->string('ATM', 60)->nullable();
            
            $table->unsignedTinyInteger('enabled');
            $table->unsignedTinyInteger('data_completion');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

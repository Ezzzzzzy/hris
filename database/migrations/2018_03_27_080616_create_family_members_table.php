<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('family_type', 60);
            $table->string('name', 60);
            $table->string('age', 60);
            $table->string('occupation', 255);

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
        Schema::dropIfExists('family_members');
    }
}

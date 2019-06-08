<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('description')->after('guard_name')->nullable();
            $table->tinyInteger('status')->after('description');
            $table->string('status_color')->after('status');
        });

        Schema::create('role_has_clients', function(Blueprint $table){
            $table->unsignedInteger('role_id');
            $table->unsignedBigInteger('client_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
            
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->boolean('is_verified')->default(0)->after('password');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastModifiedByColumnToBusinessUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_units', function (Blueprint $table) {
            $table->string('last_modified_by', 60)->after('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_units', function (Blueprint $table) {
            $table->dropColumn('last_modified_by');       
        });
    }
}

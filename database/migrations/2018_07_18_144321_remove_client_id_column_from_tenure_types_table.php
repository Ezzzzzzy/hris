<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveClientIdColumnFromTenureTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenure_types', function (Blueprint $table) {
            $table->integer('month_start_range')->nullable()->change();
            $table->integer('month_end_range')->nullable()->change();
            
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenure_types', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });
    }
}

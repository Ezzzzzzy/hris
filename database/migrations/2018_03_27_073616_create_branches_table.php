<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('branch_name', 60);
            $table->unsignedTinyInteger('enabled');
            $table->string('last_modified_by', 60);

            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('brand_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('location_id')
                  ->references('id')
                  ->on('locations');

            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['brand_id']);
        });
        
        Schema::dropIfExists('branches');
    }
}

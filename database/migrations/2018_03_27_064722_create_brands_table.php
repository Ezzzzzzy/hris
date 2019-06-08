<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand_name');
            $table->unsignedTinyInteger('enabled');

            $table->unsignedBigInteger('business_unit_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients');

            $table->foreign('business_unit_id')
                  ->references('id')
                  ->on('business_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['business_unit_id']);
        });
        
        Schema::dropIfExists('brands');
    }
}

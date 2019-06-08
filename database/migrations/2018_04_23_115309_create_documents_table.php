<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document_name', 60);
            $table->text('path');
            $table->text('s3_link');
            $table->string('last_modified_by', 60);

            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('document_type_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members');

            $table->foreign('document_type_id')
                  ->references('id')
                  ->on('document_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropForeign(['document_type_id']);
        });

        Schema::dropIfExists('documents');
    }
}
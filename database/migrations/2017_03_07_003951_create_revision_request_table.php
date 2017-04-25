<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('revision_request_number')->nullable();
            $table->integer('user_id');
            $table->string('user_name');
            $table->integer('reference_document_id')->nullable();
            $table->mediumText('reference_document_tags')->nullable();
            $table->mediumText('proposed_revision')->nullable();
            $table->mediumText('revision_reason');
            $table->string('status')->default('New');
            $table->boolean('has_appeal')->default(false);
            $table->boolean('uses_old_attachment')->default(false);
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
        Schema::dropIfExists('revision_requests');
    }
}

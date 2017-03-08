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
            $table->integer('author_id');
            $table->string('author_name');
            $table->integer('reference_document_id')->nullable();
            $table->mediumText('reference_document_body')->nullable();
            $table->mediumText('proposed_revision');
            $table->mediumText('revision_reason');
            $table->mediumText('recommendation_reason')->nullable();
            $table->string('recommendation_status')->nullable(); // approved; denied;
            $table->mediumText('ceo_remarks')->nullable();
            $table->tinyInteger('approved')->nullable();
            $table->string('action_taken')->nullable();     // updated; revised; distributed; others;
            $table->string('status')->default('pending');   //new; pending; received; processing; done;
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionRequestSectionDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_requests_section_d', function (Blueprint $table) {
            $table->increments('id');
            $table->string('revision_request_id')->nullable();
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('action_taken');     // updated; revised; distributed; others;
            $table->string('others')->nullable();
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
        Schema::dropIfExists('revision_requests_section_d');
    }
}

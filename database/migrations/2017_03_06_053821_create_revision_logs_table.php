<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->date('date');
            $table->string('revision_number');
            $table->string('manual_reference');
            $table->string('description');
            $table->string('approved_by');
            $table->string('encoded_by');
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
        Schema::dropIfExists('revision_logs');
    }
}

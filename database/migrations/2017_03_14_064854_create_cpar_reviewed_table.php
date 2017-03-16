<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCparReviewedTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cpar_reviewed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cpar_id');
            $table->boolean('status')->default(0);
            $table->boolean('on_review')->default(0);
            $table->string('reviewed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cpar_reviewed');
    }
}

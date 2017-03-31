<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCparClosedTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cpar_closed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cpar_id');
            $table->boolean('status')->default(0);
            $table->string('closed_by')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('notified')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cpar_closed');
    }
}

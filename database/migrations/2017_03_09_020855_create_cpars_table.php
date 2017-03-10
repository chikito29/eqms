<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCparsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->string('tags');
            $table->string('cpar_number');
            $table->string('raised_by');
            $table->string('department');
            $table->string('severity');
            $table->string('source');
            $table->string('other_source')->nullable();
            $table->text('details');
            $table->string('person_reporting');
            $table->string('person_responsible');
            $table->text('correction')->nullable();
            $table->text('root_cause');
            $table->text('cp_action')->nullable();
            $table->date('proposed_date')->nullable();
            $table->date('date_completed')->nullable();
            $table->string('department_head');
            $table->string('date_confirmed_by')->nullable();
            $table->date('date_accepted')->nullable();
            $table->date('date_verified')->nullable();
            $table->string('verified_by')->nullable();
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
        Schema::dropIfExists('cpars');
    }
}

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
            $table->integer('cpar_answered_id')->nullable();
            $table->integer('cpar_reviewed_id')->nullable();
            $table->integer('cpar_closed_id')->nullable();
            $table->text('tags');
            $table->string('cpar_number')->unique();
            $table->string('raised_by');
            $table->string('department');
            $table->string('severity');
            $table->longText('source');
            $table->longText('other_source')->nullable();
            $table->longText('details');
            $table->string('person_reporting');
            $table->string('person_responsible');
            $table->longText('correction')->nullable();
            $table->longText('root_cause');
            $table->longText('cp_action')->nullable();
            $table->dateTime('proposed_date')->nullable();
            $table->dateTime('date_completed')->nullable();
            $table->string('department_head');
            $table->longText('cpar-acceptance');
            $table->string('date_confirmed_by')->nullable();
            $table->dateTime('date_accepted')->nullable();
            $table->dateTime('date_verified')->nullable();
            $table->string('verified_by')->nullable();
            $table->longText('result')->nullable();
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

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
            $table->text('branch');
            $table->string('cpar_number')->nullable()->unique();
            $table->integer('raised_by')->nullable();
            $table->string('department');
            $table->string('severity');
            $table->string('source');
            $table->longText('other_source')->nullable();
            $table->longText('details');
            $table->integer('person_reporting')->nullable();
            $table->integer('person_responsible');
            $table->longText('correction')->nullable();
            $table->longText('root_cause')->nullable();
            $table->longText('cp_action')->nullable();
            $table->date('proposed_date');
            $table->date('date_completed')->nullable();
            $table->string('chief');
            $table->longText('cpar_acceptance')->nullable();
            $table->date('date_confirmed')->nullable();
            $table->date('date_accepted')->nullable();
            $table->date('date_verified')->nullable();
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category');
            $table->string('name0');
            $table->string('com0');
            $table->string('name1')->nullable();
            $table->string('com1')->nullable();
            $table->string('name2')->nullable();
            $table->string('com2')->nullable();
            $table->string('name3')->nullable();
            $table->string('com3')->nullable();
            $table->string('name4')->nullable();
            $table->string('com4')->nullable();
            $table->string('name5')->nullable();
            $table->string('com5')->nullable();
            $table->string('name6')->nullable();
            $table->string('com6')->nullable();
            $table->string('name7')->nullable();
            $table->string('com7')->nullable();
            $table->string('name8')->nullable();
            $table->string('com8')->nullable();
            $table->string('name9')->nullable();
            $table->string('com9')->nullable();
            $table->unsignedBigInteger('election_id');
            $table->foreign('election_id')->references('id')->on('elections');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}

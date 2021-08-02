<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->integer('age');
            $table->string('sex');
            $table->float('weight');
            $table->string('color');
            $table->string('chip');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('specie_id');
            $table->foreign('specie_id')->references('id')->on('species')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('breed_id');
            $table->foreign('breed_id')->references('id')->on('breeds')->onUpdate('cascade')->onDelete('cascade');
            $table->date('registration_date');
            $table->string('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}

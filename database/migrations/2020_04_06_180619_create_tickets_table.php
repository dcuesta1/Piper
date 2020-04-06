<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('column_id')->unsigned()->index();
            $table->foreign('column_id')->references('id')->on('columns')->onDelete('cascade');
            $table->bigInteger('creator_id')->unsigned()->index();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->integer('number');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}

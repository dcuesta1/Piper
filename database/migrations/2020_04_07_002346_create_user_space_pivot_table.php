<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSpacePivotTable extends Migration
{
    public function up()
    {
        Schema::create('user_space_pivot', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('space_id')->unsigned()->index();
            $table->foreign('space_id')->references('id')->on('spaces');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_space_pivot');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombinationsTable extends Migration {

    public function up()
    {
        Schema::create('combinations', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('combination_type_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('class_name', 100)->nullable();
            $table->string('color_code', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::drop('combinations');
    }
}

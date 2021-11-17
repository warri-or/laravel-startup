<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombinationTypesTable extends Migration {

    public function up()
    {
        Schema::create('combination_types', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 255);
        });
    }

    public function down()
    {
        Schema::drop('combination_types');
    }
}

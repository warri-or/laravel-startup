<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('sort_number')->default(0);
			$table->string('name');
			$table->string('slug')->unique();
			$table->integer('parent_id')->default(0);
			$table->tinyInteger('status')->default('1');
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}

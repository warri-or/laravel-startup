<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messaging', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('event_type');
            $table->bigInteger('event_id')->nullable();
            $table->bigInteger('receiver')->nullable();
            $table->bigInteger('sender')->nullable();
            $table->tinyInteger('seen')->default(0);
            $table->date('last_message_date')->nullable();
            $table->tinyInteger('synced')->default(0);
            $table->text('last_message')->nullable();
            $table->tinyInteger('is_connected')->default(0);
            $table->tinyInteger('status')->nullable(0);
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
        Schema::dropIfExists('messagings');
    }
}

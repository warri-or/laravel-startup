<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone',20)->nullable();
            $table->string('country',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('state',50)->nullable();
            $table->string('post_code',30)->nullable();
            $table->text('address')->nullable();
            $table->string('nid',30)->nullable();
            $table->string('tin',30)->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('language')->nullable();
            $table->text('address_secondary')->nullable();
            $table->decimal('balance',8,2)->default(0);
            $table->decimal('btc_balance',18,18)->default(0);
            $table->boolean('is_social_login')->default(FALSE);
            $table->string('google_id')->nullable();
            $table->string('fb_id')->nullable();
            $table->tinyInteger('admin_verified')->default(0);
            $table->string('nid_picture')->nullable();
            $table->string('social_image_link')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('email_verified')->nullable();
            $table->string('password');
            $table->string('reset_password_code')->nullable();
            $table->string('remember_token')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->tinyInteger('default_module_id')->default(1);
            $table->integer('role')->default(0);
            $table->timestamps();
            $table->tinyInteger('status')->default(INACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

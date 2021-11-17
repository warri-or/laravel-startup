<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payment_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->enum('payment_type',['Bank','Card','Coin'])->default('Card');
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->enum('card_type',['Visa','Master','Amex'])->nullable();
            $table->string('card_name')->nullable();
            $table->string('card_number')->nullable();
            $table->smallInteger('cvc')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('coin_address')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('user_payment_options');
    }
}

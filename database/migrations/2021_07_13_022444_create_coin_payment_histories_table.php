<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->text('address')->nullable();
            $table->string('currency')->nullable();
            $table->text('txn_id')->nullable();
            $table->decimal('amount',20,18)->nullable();
            $table->integer('confirms')->default(0);
            $table->integer('ipn_type')->nullable();
            $table->string('status')->nullable();
            $table->longText('transaction_details')->nullable();
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
        Schema::dropIfExists('coin_payment_histories');
    }
}

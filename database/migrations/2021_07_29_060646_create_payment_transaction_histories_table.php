<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->nullable();
            $table->tinyInteger('purpose')->nullable();
            $table->tinyInteger('payment_method')->nullable();
            $table->decimal('amount')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->text('transaction_reference')->nullable();
            $table->tinyInteger('payment_status')->nullable();
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
        Schema::dropIfExists('payment_transaction_histories');
    }
}

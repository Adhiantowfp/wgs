<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentVerifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment__verifies', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('user_id');
            $table->string('price_total');
            $table->string('image_payment');
            $table->string('payment_type');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_id')->references('payment_id')->on('user__checkouts');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment__verifies');
    }
}

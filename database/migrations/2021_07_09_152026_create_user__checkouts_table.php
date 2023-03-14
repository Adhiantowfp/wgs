<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();
            $table->string('user_id');
            $table->string('address_id');
            $table->string('product_id');
            $table->string('product_quantity');
            $table->string('product_price');
            $table->string('price_total');
            $table->string('order_notes')->nullable();
            $table->string('payment_type');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('address_id')->references('address_id')->on('user__addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user__checkouts');
    }
}

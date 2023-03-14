<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique();
            $table->string('product_name');
            $table->string('product_image');
            $table->string('product_type');
            $table->string('product_quantity');
            $table->text('product_description')->nullable();
            $table->text('product_detail')->nullable();
            $table->string('product_price');
            $table->string('product_discount')->nullable();
            $table->string('product_category');
            $table->string('product_rating');
            $table->string('product_review');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}

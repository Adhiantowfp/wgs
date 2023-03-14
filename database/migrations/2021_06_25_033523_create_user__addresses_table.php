<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address_id')->unique();
            $table->string('user_id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('province');
            $table->string('city');
            $table->string('districts');
            $table->string('zip_code');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('user__addresses');
    }
}

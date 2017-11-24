<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCartPayment111317440PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cart_payment', function (Blueprint $table) {
            $table->increments('cart_payment_id');
            $table->integer('shop_id');
            $table->string('unique_id_per_pc');
            $table->string('payment_type');
            $table->double('payment_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_cart_payment');
    }
}

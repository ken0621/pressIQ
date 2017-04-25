<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblUserAddStockistA extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_user', function (Blueprint $table) {
            //
            $table->integer('user_stockist_is')->default(0);
            $table->integer('user_stockist_customer_id')->default(0);
            $table->integer('user_stockist_shop_head')->default(0);
        });

        Schema::table('tbl_shop', function (Blueprint $table) {
            //
            $table->integer('shop_stockist_is')->default(0);
            $table->integer('shop_stockist_shop_head')->default(0);
        });

        Schema::table('tbl_customer', function (Blueprint $table) {
            //
            $table->integer('customer_stockist_is')->default(0);
            $table->integer('customer_stockist_user_id')->default(0);
            $table->integer('customer_stockist_shop_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_user', function (Blueprint $table) {
            //
        });
    }
}

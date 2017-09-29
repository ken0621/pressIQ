<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTransactionItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaction_list', function (Blueprint $table)
        {
            $table->increments('transaction_item_id');
            $table->integer('item_id')->unsigned();
            $table->string('item_name');
            $table->string('item_sku');
            $table->double('item_price');
            $table->integer('quantity');
            $table->double('discount');
            $table->double('subtotal');
            $table->foreign('item_id')->references('item_id')->on('tbl_item')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

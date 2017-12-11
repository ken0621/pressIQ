<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountingTransaction12110717435PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accounting_transaction', function (Blueprint $table) {
            $table->increments('accounting_transaction_id');
            $table->integer('shop_id')->unsigned();
            $table->string('transaction_number');

            $table->foreign('shop_id')->references('shop_id')->on("tbl_shop")->onDelete('cascade');
        });
         Schema::create('tbl_accounting_transaction_list', function (Blueprint $table) {
            $table->increments('accounting_transaction_list_id');
            $table->integer('accounting_transaction_id')->unsigned();
            $table->string('transaction_ref_name');
            $table->integer('transaction_ref_id');
            $table->string('transaction_list_number');
            $table->date('transaction_date');
            $table->datetime('date_created');
            
            $table->foreign('accounting_transaction_id')->references('accounting_transaction_id')->on("tbl_accounting_transaction")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_accounting_transaction');
    }
}

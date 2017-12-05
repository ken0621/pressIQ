<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblTransactionRefNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaction_ref_number', function (Blueprint $table) {
            $table->increments('trans_ref_number_id');
            $table->integer('po_id'); // tbl_purchase_order
            


            $table->string('key');
            $table->string('prefix');
            $table->string('other');
            $table->string('separator');

            $table->timestamps();
            
            $table->foreign('po_id')->references('po_id')->on('tbl_purchase_order')->onDelete('cascade');
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

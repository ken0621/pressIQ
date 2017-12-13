<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTransactionRefNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaction_reference_number', function (Blueprint $table) {
            $table->increments('trans_ref_number_id');
            $table->string('shop_id');
            $table->string('key');
            $table->string('prefix');
            $table->string('other');
            $table->string('separator');
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
        //
    }
}

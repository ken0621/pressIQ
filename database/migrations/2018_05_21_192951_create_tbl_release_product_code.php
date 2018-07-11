<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblReleaseProductCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_release_product_code', function (Blueprint $table) 
        {
            $table->increments('release_product_id');
            $table->string('receipt_number');
            $table->double('amount');
            $table->string('cellphone_number');
            $table->string('email');
            $table->integer('customer_id')->unsigned();
            $table->integer('record_log_id')->unsigned();
            $table->tinyInteger('archived')->default(0);

            $table->foreign('customer_id')
                  ->references('customer_id')->on('tbl_customer')
                  ->onDelete('cascade');

            $table->foreign('record_log_id')
                  ->references('record_log_id')->on('tbl_warehouse_inventory_record_log')
                  ->onDelete('cascade');
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

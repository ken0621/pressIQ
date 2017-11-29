<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAir21 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_air21', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('transaction_list_id')->unsigned();
            $table->binary('response');
            $table->tinyInteger('success')->default(0);
            $table->string('message');
            $table->string('tracking_num');
            $table->dateTime('shp_date');
            $table->dateTime('response_date');

            $table->foreign('transaction_list_id')
                  ->references('transaction_list_id')->on('tbl_transaction_list')
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

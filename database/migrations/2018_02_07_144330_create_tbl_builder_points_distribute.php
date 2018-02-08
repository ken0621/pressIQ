<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBuilderPointsDistribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_builder_points_distribute', function (Blueprint $table) 
        {
            $table->increments('builder_distribute_id');
            $table->integer('shop_id')->unsigned();
            $table->integer('log_wallet_id')->unsigned();
            $table->integer('slot_id');
            $table->double('amount_distributed');
            $table->integer('distribute_batch');
            $table->dateTime('date_created');
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

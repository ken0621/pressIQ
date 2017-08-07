<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblDragonpayLogsOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_dragonpay_logs', function (Blueprint $table) 
        {
            $table->renameColumn('content', 'response');
            $table->integer('order_id');
        });
        
        Schema::create('tbl_dragonpay_logs_other', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->dateTime('log_date');
            $table->integer('order_id');
            $table->binary('response');
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

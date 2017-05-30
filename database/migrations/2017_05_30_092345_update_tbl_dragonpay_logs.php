<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblDragonpayLogs extends Migration
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
            $table->string('merchantid');
            $table->string('txnid');
            $table->string('amount');
            $table->string('merchantid');
            $table->string('merchantid');
            $table->string('merchantid');
            $table->string('merchantid');
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

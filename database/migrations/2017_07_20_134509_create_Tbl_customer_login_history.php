<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCustomerLoginHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_customer_login_history', function (Blueprint $table) {
            $table->increments('customer_login_history_id');
            $table->datetime('customer_login_history_login');
            $table->datetime('customer_login_history_logout')->nullable();
            $table->datetime('customer_login_history_last_activity')->nullable();
            $table->integer('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_customer_login_history');
    }
}

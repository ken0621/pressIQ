<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblCustomeRLoginHistoryAddIpaddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_customer_login_history', function (Blueprint $table) {
            //
            $table->string('ip_address')->nullable();
            $table->string('ip_browser')->nullable();
            $table->string('ip_device')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_customer_login_history', function (Blueprint $table) {
            //
        });
    }
}

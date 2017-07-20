<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTblCustomeRLoginHistoryAddAccount extends Migration
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
            $table->string('customer_username')->nullable();
            $table->text('customer_password')->nullable();
            $table->integer('status')->default(1);
            $table->string('status_message')->nullable();
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

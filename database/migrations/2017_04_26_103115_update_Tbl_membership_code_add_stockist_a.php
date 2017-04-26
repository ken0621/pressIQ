<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblMembershipCodeAddStockistA extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_membership_code', function (Blueprint $table) {
            //
            $table->integer('membership_stockist_is')->default(0);
            $table->integer('membership_stockist_user_use')->default(0);
        });

        Schema::table('tbl_membership_code_invoice', function (Blueprint $table) {
            //
            $table->integer('member_code_invoice_is_stockist')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_membership_code', function (Blueprint $table) {
            //
        });
    }
}

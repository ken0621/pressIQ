<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblPayrollShiftCodeV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_payroll_shift_code', function (Blueprint $table) {
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('shop_id')->on('tbl_shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_payroll_shift_code', function (Blueprint $table) {
            //
        });
    }
}

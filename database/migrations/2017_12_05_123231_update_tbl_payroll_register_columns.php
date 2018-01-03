<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblPayrollRegisterColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
                    Schema::table('tbl_payroll_register_columns', function (Blueprint $table) {
                   $table->tinyInteger('name');
                   $table->tinyInteger('gross_basic_pay');
                   $table->tinyInteger('absent');
                   $table->tinyInteger('late');
                   $table->tinyInteger('undertime');
                   $table->tinyInteger('basic_pay');
                   $table->tinyInteger('cola');
                   $table->tinyInteger('overtime_pay');
                   $table->tinyInteger('night_differential_pay');
                   $table->tinyInteger('regular_holiday_pay');
                   $table->tinyInteger('special_holiday_pay');
                   $table->tinyInteger('restday_pay');
                   $table->tinyInteger('leave_pay');
                   $table->tinyInteger('allowance');
                   $table->tinyInteger('bonus');
                   $table->tinyInteger('commision');
                   $table->tinyInteger('incentives');
                   $table->tinyInteger('additions');
                   $table->tinyInteger('13th_month_and_other');
                   $table->tinyInteger('de_minimis_benefit');
                   $table->tinyInteger('others');
                   $table->tinyInteger('gross_pay');
                   $table->tinyInteger('deductions');
                   $table->tinyInteger('cash_bond');
                   $table->tinyInteger('cash_advance');
                   $table->tinyInteger('other_loan');
                   $table->tinyInteger('sss_loan');
                   $table->tinyInteger('sss_ee');
                   $table->tinyInteger('hdmf_loan');
                   $table->tinyInteger('hdmf_ee');
                   $table->tinyInteger('phic_ee');
                   $table->tinyInteger('with_holding_tax');
                   $table->tinyInteger('total_deduction');
                   $table->tinyInteger('take_home_pay');
                   $table->tinyInteger('sss_er');
                   $table->tinyInteger('sss_ec');
                   $table->tinyInteger('hdmf_er');
                   $table->tinyInteger('phic_er');

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

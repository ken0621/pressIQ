<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCommissionInvoiceAgent792018152PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_commission_invoice_agent', function (Blueprint $table) {
            $table->increments("invoice_agent_id");
            $table->integer("agent_comm_inv_id")->unsigned();
            $table->integer("comm_agent_id")->unsigned();
            $table->double("agent_percent")->default(0)->nullable();
            $table->double("agent_amount")->default(0)->nullable();
            $table->double("agent_commission_amount")->default(0)->nullable();

            $table->foreign("agent_comm_inv_id")->references("comm_inv_id")->on("tbl_commission_invoice")->onDelete("cascade");
            $table->foreign("comm_agent_id")->references("employee_id")->on("tbl_employee")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_commission_invoice_agent', function (Blueprint $table) {
            //
        });
    }
}

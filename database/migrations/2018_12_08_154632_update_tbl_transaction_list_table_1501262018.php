<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblTransactionListTable1501262018 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_transaction_list', function (Blueprint $table) {
            $table->string("transaction_payment_method")->nullable()->after("transaction_remark");
            $table->string("transaction_payment_method_type")->nullable()->after("transaction_remark");
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

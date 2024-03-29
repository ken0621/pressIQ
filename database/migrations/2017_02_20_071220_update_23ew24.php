<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update23ew24 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_temp_customer_invoice', function (Blueprint $table) {
            $table->tinyInteger("is_sync")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_temp_customer_invoice', function (Blueprint $table) {
            //
        });
    }
}

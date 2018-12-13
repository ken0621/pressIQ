<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPaymentTypeTable12112018602 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payment_type', function (Blueprint $table) {
            $table->increments("payment_type_id");
            $table->string("payment_type_name");
            $table->tinyInteger("is_archived")->default(0);
        });

        Schema::create('tbl_payment_tag', function (Blueprint $table) {
            $table->increments("payment_tag_id");
            $table->integer("payment_method_id");
            $table->integer("payment_type_id");
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

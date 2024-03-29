<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAboutUs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_about_us', function (Blueprint $table) {
            $table->increments('about_us_id');
            $table->integer('shop_id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->datetime('date_created');
            $table->tinyInteger('archived');
        });
        Schema::table('tbl_about_us', function($table) {
           $table->foreign('shop_id')->references('shop_id')->on('tbl_shop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_about_us');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPdfTemplateV0 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pdf_report_type', function (Blueprint $table) {
            $table->increments('report_type_id');
            $table->integer('report_type_shop_id')->unsigned();
            $table->string('report_type');
            $table->string('report_type_code');
            $table->datetime('ceated_at');

            $table->foreign("report_type_shop_id")->references("shop_id")->on("tbl_shop")->onDelete('cascade');
        });
        Schema::create('tbl_pdf_template', function (Blueprint $table) {
            $table->increments('template_id');
            $table->integer('template_shop_id');
            $table->string('template_img');
            $table->tinyInteger('template_img_show');
            $table->string('template_img_size');
            $table->string('template_img_placement');
            $table->integer('tmplt_report_type_id')->unsigned();
            $table->datetime('ceated_at');
            $table->tinyInteger('is_default')->default(0);

            $table->foreign("tmplt_report_type_id")->references("report_type_id")->on("tbl_pdf_report_type")->onDelete('cascade');
        });

        Schema::create('tbl_pdf_template_content', function (Blueprint $table) {
            $table->increments('tmplt_content_id');
            $table->integer('tmplt_id')->unsigned();
            $table->integer('tmplt_column_name');
            $table->tinyInteger('tmplt_column_show');

            $table->foreign("tmplt_id")->references("template_id")->on("tbl_pdf_template")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_pdf_template');
    }
}

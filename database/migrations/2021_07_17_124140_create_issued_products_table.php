<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issued_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->string('name_of_patient');
            $table->string('town');
            $table->integer('district_id')->unsigned();
            $table->integer('issued_by')->unsigned()->nullable();
            $table->integer('age_of_patient')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('quantity_before_issued_out')->nullable();
            $table->date('date_issued')->nullable();
            $table->string('gender');
            $table->string('status')->default('completed'); //if pending then its yet to be issued out
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issued_products');
    }
}

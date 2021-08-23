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
            $table->integer('victim_id');
            $table->string('town');
            $table->integer('issued_by')->unsigned()->nullable();
            $table->integer('quantity')->unsigned();
            $table->integer('quantity_before_issued_out')->nullable();
            $table->date('date_issued')->nullable();
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

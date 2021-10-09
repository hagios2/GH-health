<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityAfterIssuedOutToIssuedOutProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issued_products', function (Blueprint $table) {
            $table->integer('quantity_after_issued_out')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issued_out_products', function (Blueprint $table) {
            $table->dropColumn(['quantity_after_issued_out']);
        });
    }
}

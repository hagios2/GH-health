<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('paid_at');
            $table->integer('months_paid_for')->unsigned()->default(1);
            $table->integer('user_id')->unsigned()->mullable();
            $table->integer('merchandiser_id')->unsigned()->nullable();
            $table->string('txRef')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('sellers_payments');
    }
}

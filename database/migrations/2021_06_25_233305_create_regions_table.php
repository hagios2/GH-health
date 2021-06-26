<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_of_regional_minister')->nullable();
            $table->string('address_of_regional_minister')->nullable();
            $table->string('name_of_director_general')->nullable();
            $table->string('address_of_director_general')->nullable();
            $table->string('name_of_regional_health_director')->nullable();
            $table->string('address_of_regional_health_director')->nullable();
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
        Schema::dropIfExists('regions');
    }
}

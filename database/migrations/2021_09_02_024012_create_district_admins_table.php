<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('district_id')->unsigned();
            $table->string('email');
            $table->boolean('isActive')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('must_change_password')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('district_admins');
    }
}

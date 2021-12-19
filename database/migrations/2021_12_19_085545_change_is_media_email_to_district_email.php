<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIsMediaEmailToDistrictEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_password_resets', function (Blueprint $table) {
            $table->renameColumn('isMediaEmail', 'isDistrictEmail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_password_resets', function (Blueprint $table) {
            //
        });
    }
}

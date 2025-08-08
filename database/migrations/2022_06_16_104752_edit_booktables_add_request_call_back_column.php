<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBooktablesAddRequestCallBackColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('booktables', function (Blueprint $table) {
            $table->integer('request_call_back')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('booktables', function (Blueprint $table) {
            $table->dropColumn('request_call_back');
        });
    }
}

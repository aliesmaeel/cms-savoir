<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPhoneWhatsappToQualifiedLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualified_leads', function (Blueprint $table) {
            $table->string("phone_whatsapp")->nullable();
            $table->string("mobile")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qualified_leads', function (Blueprint $table) {
            //
        });
    }
}

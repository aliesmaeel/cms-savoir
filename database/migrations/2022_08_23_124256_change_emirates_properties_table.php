<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEmiratesPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emirates_properties', function (Blueprint $table) {
            $table->dropForeign(['newProperty_id']);
            $table->foreign('newProperty_id')
                ->references('id')
                ->on('new_properties')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emirates_properties', function (Blueprint $table) {
            $table->dropColumn("newProperty_id");
        });
    }
}

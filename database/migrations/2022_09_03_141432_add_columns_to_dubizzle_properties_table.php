<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDubizzlePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dubizzle_properties', function (Blueprint $table) {
            $table->string('developer')->nullable(true);
            $table->string('furnished')->nullable(true);
            $table->string('view360')->nullable(true);
            $table->string('geopoints')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dubizzle_properties', function (Blueprint $table) {
            //
        });
    }
}

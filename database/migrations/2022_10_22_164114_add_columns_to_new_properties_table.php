<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNewPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_properties', function (Blueprint $table) {
            $table->integer('bedroom')->nullable(false);
            $table->integer('bathroom')->nullable(true);
            $table->integer('price')->nullable(false);
            $table->integer('size')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_properties', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditNewPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_properties', function (Blueprint $table) {
            $table->string('sub_community')->nullable(true)->change();
            $table->string('bedroom')->nullable(true)->change();
            $table->string('community')->nullable(true)->change();
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
            $table->string('sub_community')->nullable(false)->change();
            $table->string('community')->nullable(false)->change();
            $table->string('bedroom')->nullable(false)->change();
        });
    }
}

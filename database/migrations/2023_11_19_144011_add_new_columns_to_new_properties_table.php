<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToNewPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_properties', function (Blueprint $table) {
            $table->string('property_name')->nullable(true);
            $table->string('property_status')->default('Live');
            $table->string('completion_status')->nullable(true);
            $table->string('country')->nullable(true);
            $table->string('lat')->nullable(true);
            $table->string('lng')->nullable(true);
             $table->string('currency')->nullable(true);
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
            $table->dropColumn('property_name');
            $table->dropColumn('property_status');
            $table->dropColumn('completion_status');
            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('country');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OnlineChangeNewPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_properties', function (Blueprint $table) {
            $table->dropColumn('service_charge');
            $table->dropColumn('cheques');
            $table->dropColumn('property_name');
            $table->dropColumn('plot_size');
            $table->dropColumn('developer');
            $table->dropColumn('build_year');
            $table->dropColumn('completion_status');
            $table->dropColumn('floor');
            $table->dropColumn('stories');
            $table->dropColumn('parking');
            $table->dropColumn('furnished');
            $table->dropColumn('view360');
            $table->dropColumn('geopoints');
            $table->dropColumn('title_deed');
            $table->dropColumn('availability_date');
            $table->boolean('finder')->nullable(false)->default(false);
            $table->boolean('bayut')->nullable(false)->default(false);
            $table->boolean('emirates_estate')->nullable(false)->default(false);
            $table->boolean('dubizzle')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

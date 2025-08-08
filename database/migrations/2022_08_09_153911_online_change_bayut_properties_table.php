<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OnlineChangeBayutPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bayut_properties', function (Blueprint $table) {
            $table->dropColumn('property_ref_no');
            $table->dropColumn('property_purpose');
            $table->dropColumn('property_type');
            $table->dropColumn('city');
            $table->dropColumn('locality');
            $table->dropColumn('sub_locality');
            $table->dropColumn('property_title');
            $table->dropColumn('property_title_ar');
            $table->dropColumn('property_description');
            $table->dropColumn('property_description_ar');
            $table->dropColumn('property_size');
            $table->dropColumn('bedrooms');
            $table->dropColumn('bathroom');
            $table->dropColumn('price');
            $table->dropForeign(['user_id']);
            $table->dropColumn("user_id");
            $table->dropColumn('features');
            $table->dropColumn('images');
            $table->dropColumn('floor_plans');
            $table->dropColumn('permit_number');
            $table->foreignId('newProperty_id')->nullable(true);
            $table->foreign('newProperty_id')
            ->references('id')
            ->on('new_properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}

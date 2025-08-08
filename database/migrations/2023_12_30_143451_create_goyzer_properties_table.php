<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoyzerPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goyzer_properties', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('code')->nullable();
            $table->string('status')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('community')->nullable();
            $table->string('property_name')->nullable();
            $table->string('built_up_area')->nullable();
            $table->string('no_of_floors')->nullable();
            $table->string('handover_date')->nullable();
            $table->string('agent')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('remarks')->nullable();
            $table->string('community_description')->nullable();
            $table->string('unique_selling_points')->nullable();
            $table->string('facilities')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('sub_community')->nullable();
            $table->string('country_code')->nullable();
            $table->string('vicinity')->nullable();
            $table->string('appartments')->nullable();
            $table->string('lowest_price_unit')->nullable();
            $table->string('shops')->nullable();
            $table->string('offices')->nullable();
            $table->string('currency_abr')->nullable();
            $table->string('measurement')->nullable();
            $table->string('lowest_size_unit')->nullable();
            $table->string('property_over_view')->nullable();
            $table->string('locala_area_amenities_desc')->nullable();
            $table->string('site_info_amenities_desc')->nullable();
            $table->string('developer_desc')->nullable();
            $table->string('completion_date')->nullable();
            $table->string('property_owner_ship_desc')->nullable();
            $table->string('country_id')->nullable();
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('community_id')->nullable();
            $table->string('sub_community_id')->nullable();
            $table->string('agent_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('googlcoordinates')->nullable();
            $table->string('escrow_account_no')->nullable();
            $table->string('Images')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goyzer_properties');
    }
}

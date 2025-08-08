<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGoyzerToNewPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_properties', function (Blueprint $table) {
            $table->boolean('goyzer')->default('0');
        });
        Schema::table('property_images', function (Blueprint $table) {
            $table->boolean('is_external_image')->default('0');
        });
        Schema::dropIfExists('goyzer_properties');
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
            $table->string('sub_community')->nullable();
            $table->string('property_over_view')->nullable();
            $table->string('locala_area_amenities_desc')->nullable();
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
            $table->json('Images')->nullable();
            $table->string('page_index')->nullable();
            $table->string('count')->nullable();
            $table->string('bedrooms')->nullable();
            $table->string('primary_unit_view')->nullable();
            $table->string('secondary_unit_view')->nullable();
            $table->string('unitmodel')->nullable();
            $table->string('country_name')->nullable();
            $table->string('state_name')->nullable();
            $table->string('district_name')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('document_web')->nullable();
            $table->string('sell_price')->nullable();
            $table->string('subtype')->nullable();
            $table->string('parking')->nullable();
            $table->string('financing_company')->nullable();
            $table->string('marketing_usp')->nullable();
            $table->string('property_ownership_desc')->nullable();
            $table->string('retunit_category')->nullable();
            $table->string('property_id')->nullable();
            $table->string('PDF_brochure_link')->nullable();
            $table->string('agent_rera_no')->nullable();
            $table->string('BdmPkg')->nullable();
            $table->string('salesman_email')->nullable();
            $table->string('last_updated')->nullable();
            $table->string('Listing_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('recommended_propertie')->nullable();
            $table->string('marketing_title')->nullable();
            $table->string('marketing_options')->nullable();
            $table->string('agent_photo')->nullable();
            $table->string('arabic_title')->nullable();
            $table->string('currency_abr')->nullable();
            $table->string('mandate')->nullable();
            $table->string('arabic_description')->nullable();
            $table->string('area_measurement')->nullable();
            $table->string('rera_str_no')->nullable();
            $table->string('furnish_status')->nullable();
            $table->string('listing_type')->nullable();
            $table->string('fitting_fixtures')->nullable();
            $table->string('documents')->nullable();
            $table->string('offering_type')->nullable();
            $table->string('custom_fields')->nullable();
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
        Schema::table('new_properties', function (Blueprint $table) {
            $table->dropColumn('goyzer');
        });
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropColumn('is_external_image');
        });
        Schema::dropIfExists('goyzer_properties');
    }
}

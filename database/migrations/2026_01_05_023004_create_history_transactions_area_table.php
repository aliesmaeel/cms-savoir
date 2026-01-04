<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTransactionsAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_transactions_area', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->integer('procedure_id')->nullable();
            $table->integer('trans_group_id')->nullable();
            $table->string('trans_group_ar')->nullable();
            $table->string('trans_group_en')->nullable();
            $table->string('procedure_name_ar')->nullable();
            $table->string('procedure_name_en')->nullable();
            $table->date('instance_date')->nullable();
            $table->integer('property_type_id')->nullable();
            $table->string('property_type_ar')->nullable();
            $table->string('property_type_en')->nullable();
            $table->string('property_sub_type_id')->nullable();
            $table->string('property_sub_type_ar')->nullable();
            $table->string('property_sub_type_en')->nullable();
            $table->string('property_usage_ar')->nullable();
            $table->string('property_usage_en')->nullable();
            $table->integer('reg_type_id')->nullable();
            $table->string('reg_type_ar')->nullable();
            $table->string('reg_type_en')->nullable();
            $table->integer('area_id')->nullable();
            $table->string('area_name_ar')->nullable();
            $table->string('area_name_en')->nullable();
            $table->string('building_name_ar')->nullable();
            $table->string('building_name_en')->nullable();
            $table->string('project_number')->nullable();
            $table->string('project_name_ar')->nullable();
            $table->string('project_name_en')->nullable();
            $table->string('master_project_en')->nullable();
            $table->string('master_project_ar')->nullable();
            $table->string('nearest_landmark_ar')->nullable();
            $table->string('nearest_landmark_en')->nullable();
            $table->string('nearest_metro_ar')->nullable();
            $table->string('nearest_metro_en')->nullable();
            $table->string('nearest_mall_ar')->nullable();
            $table->string('nearest_mall_en')->nullable();
            $table->string('rooms_ar')->nullable();
            $table->string('rooms_en')->nullable();
            $table->integer('has_parking')->nullable();
            $table->decimal('procedure_area', 15, 2)->nullable();
            $table->decimal('actual_worth', 15, 2)->nullable();
            $table->decimal('meter_sale_price', 15, 2)->nullable();
            $table->decimal('rent_value', 15, 2)->nullable();
            $table->decimal('meter_rent_price', 15, 2)->nullable();
            $table->integer('no_of_parties_role_1')->nullable();
            $table->integer('no_of_parties_role_2')->nullable();
            $table->integer('no_of_parties_role_3')->nullable();
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
        Schema::dropIfExists('history_transactions_area');
    }
}

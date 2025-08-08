<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_properties', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->nullable(false);
            $table->string('permit_number')->nullable(false);
            $table->string('property_type')->nullable(false);
            $table->string('offering_type')->nullable(false);
            $table->string('price')->nullable(false);
            $table->string('city')->nullable(false);
            $table->string('title_en')->nullable(false);
            $table->string('title_ar')->nullable(true);
            $table->text('description_en')->nullable(false);
            $table->text('description_ar')->nullable(true);
            $table->string('size')->nullable(false);
            $table->string('bedroom')->nullable(false);
            $table->string('bathroom')->nullable(true);
            $table->text('photo')->nullable(true);
            $table->string('floor_plan')->nullable(true);
            $table->string('community')->nullable(false);
            $table->string('sub_community')->nullable(false);
            $table->string('private_amenities')->nullable(true);
            $table->boolean('finder')->nullable(false)->default(false);
            $table->boolean('bayut')->nullable(false)->default(false);
            $table->boolean('emirates_estate')->nullable(false)->default(false);
            $table->boolean('dubizzle')->nullable(false)->default(false);
            $table->foreignId('user_id')->nullable(true);
            $table->foreign('user_id')
            ->references('id')
            ->on('users');
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
        Schema::dropIfExists('new_properties');
    }
}

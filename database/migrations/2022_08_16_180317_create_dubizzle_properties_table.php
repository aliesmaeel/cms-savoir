<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDubizzlePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dubizzle_properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_status')->nullable(false);
            $table->string('property_size_unit')->nullable(false);
            $table->string('rent_Frequency')->nullable(false);
            $table->string('off_plan')->nullable(false);
            $table->string('videos')->nullable(true);
            $table->string('tower_name')->nullable(false);
            $table->foreignId('newProperty_id')->nullable(true);
            $table->foreign('newProperty_id')
            ->references('id')
            ->on('new_properties');
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
        Schema::dropIfExists('dubizzle_properties');
    }
}

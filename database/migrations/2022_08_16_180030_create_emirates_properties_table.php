<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmiratesPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emirates_properties', function (Blueprint $table) {
            $table->id();
            $table->string('service_charge')->nullable(true);
            $table->string('cheques')->nullable(true);
            $table->string('plot_size')->nullable(true);
            $table->string('developer')->nullable(true);
            $table->string('build_year')->nullable(true);
            $table->string('completion_status')->nullable(true);
            $table->string('floor')->nullable(true);
            $table->string('stories')->nullable(true);
            $table->string('parking')->nullable(true);
            $table->string('furnished')->nullable(true);
            $table->string('view360')->nullable(true);
            $table->string('geopoints')->nullable(true);
            $table->string('title_deed')->nullable(true);
            $table->string('availability_date')->nullable(true);
            $table->string('property_name')->nullable(false);
            $table->foreignId('newProperty_id')->nullable(true);
            $table->foreign('newProperty_id')
            ->references('id')
            ->on('new_properties')->onDelete('cascade');
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
        Schema::dropIfExists('emirates_properties');
    }
}

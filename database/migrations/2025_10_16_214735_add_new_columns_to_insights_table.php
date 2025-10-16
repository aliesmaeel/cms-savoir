<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToInsightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->string('facebook')->default(0);
            $table->string('instagram')->default(0);
            $table->string('linkedin')->default(0);
            $table->integer('shares')->default(0);
            $table->string('first_image',255)->nullable();
            $table->string('second_image',255)->nullable();
            $table->string('third_image',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insights', function (Blueprint $table) {
            //
        });
    }
}

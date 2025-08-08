<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceededLeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceeded_lead', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string("mobile")->nullable();
            $table->string("phone_whatsapp")->nullable();
            $table->string('title')->nullable(true);
            $table->integer('number_of_beds')->nullable(true);
            $table->string('comment')->nullable(true);
            $table->string('project')->nullable(true);
            $table->string('source')->nullable(true);
            $table->double('data_id')->nullable(true);
            $table->integer('created_by')->nullable(true);
            $table->integer('previous_state')->default(0);
            $table->integer('previous_state_id')->default(0);
            $table->boolean('assigned')->default(false);
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
        Schema::dropIfExists('proceeded_lead');
    }
}

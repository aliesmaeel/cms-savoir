<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOffPlanProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('off_plan_projects', function (Blueprint $table) {
            $table->string('developer')->nullable()->after('title');
            $table->string('starting_price')->nullable()->after('developer');
            $table->string('completion_date')->nullable()->after('starting_price');
            $table->string('project_size')->nullable()->after('completion_date');
            $table->string('lifestyle')->nullable()->after('project_size');
            $table->string('title_type')->nullable()->after('lifestyle');
            $table->string('first_installment')->nullable()->after('title_type');
            $table->text('youtube_link')->nullable()->after('location');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('off_plan_projects', function (Blueprint $table) {
            //
        });
    }
}

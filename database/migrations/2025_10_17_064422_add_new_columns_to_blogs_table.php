<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug',190)->unique()->after('id');
            $table->text('title_details')->nullable();
            $table->text('description_one_title')->nullable();
            $table->text('description_one')->nullable();
            $table->text('description_two_title')->nullable();
            $table->text('description_two')->nullable();
            $table->text('description_three_title')->nullable();
            $table->text('description_three')->nullable();
            $table->text('description_four_title')->nullable();
            $table->text('description_four')->nullable();
            $table->string('first_image',255)->nullable();
            $table->string('second_image',255)->nullable();
            $table->string('third_image',255)->nullable();
            $table->dropColumn('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'description_one_title',
                'description_one',
                'description_two_title',
                'description_two',
                'description_three_title',
                'description_three',
                'description_four_title',
                'description_four',
                'first_image',
                'second_image',
                'third_image'
            ]);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('P_NUMBER')->nullable();
            $table->string('AREA')->nullable();
            $table->string('USAGE')->nullable();
            $table->string('TOTAL_AREA')->nullable();
            $table->string('PLOT_NUMBER')->nullable();
            $table->string('EMIRATE')->nullable();
            $table->string('NAME')->nullable();
            $table->string('AREA_OWNED')->nullable();
            $table->string('ADDRESS')->nullable();
            $table->string('PHONE')->nullable();
            $table->string('EMAIL')->nullable();
            $table->string('FAX')->nullable();
            $table->string('PO_BOX')->nullable();
            $table->string('GENDER')->nullable();
            $table->string('DOB')->nullable();
            $table->string('MOBILE')->nullable();
            $table->string('SECONDARY_MOBILE')->nullable();
            $table->string('PASSPORT')->nullable();
            $table->string('ISSUE_DATE')->nullable();
            $table->string('EXPIRY_DATE')->nullable();
            $table->string('PLACE_OF_ISSUE')->nullable();
            $table->string('EMIRATES_ID_NUMBER')->nullable();
            $table->string('EMIRATES_ID_EXPIRY_DATE')->nullable();
            $table->string('RESIDENCE_COUNTRY')->nullable();
            $table->string('NATIONALITY')->nullable();
            $table->string('Master_Project')->nullable();
            $table->string('Project')->nullable();
            $table->string('Building_Name')->nullable();
            $table->string('Agents')->nullable();
            $table->string('Flat_Number')->nullable();
            $table->string('No_of_Beds')->nullable();
            $table->string('Floor')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('file')->nullable();
            $table->string('unique')->nullable();
            $table->Unique(['name', 'mobile' , 'phone', 'email','SECONDARY_MOBILE']);
            $table->Index(['name', 'mobile', 'phone', 'email','SECONDARY_MOBILE']);
            $table->string('phone_whatsup')->nullable();
            $table->string('MOBILE_whatsup')->nullable();
            $table->string('SECONDARY_MOBILE_wahtsup')->nullable();
            $table->string('source')->nullable(true);
            $table->integer('data_status')->nullable(true)->default('0');

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
        Schema::dropIfExists('data');
    }
}
//P-NUMBER,AREA,USAGE,TOTAL_AREA,PLOT_NUMBER,EMIRATE,NAME,AREA_OWNED,ADDRESS,PHONE,EMAIL,FAX,PO_BOX,GENDER,DOB,MOBILE,SECONDARY_MOBILE,PASSPORT,ISSUE_DATE,EXPIRY_DATE,PLACE_OF_ISSUE,EMIRATES_ID_NUMBER,EMIRATES_ID_EXPIRY_DATE,RESIDENCE_COUNTRY,NATIONALITY,Master_Project,Project,Building_Name,Agents,Flat_Number,No_of_Beds,Floor,registration_number

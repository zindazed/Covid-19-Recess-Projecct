<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficerPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officer_patients', function (Blueprint $table) {
            $table->bigIncrements("ID");
            $table->unsignedBigInteger("officer_ID");
            $table->unsignedBigInteger("patient_ID");

            $table->foreign("officer_ID")->references("officer_ID")->on("officers")->onDelete("cascade");
            $table->foreign("patient_ID")->references("patient_ID")->on("patients")->onDelete("cascade");
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
        Schema::dropIfExists('officer_patients');
    }
}

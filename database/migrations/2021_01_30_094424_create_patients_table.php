<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements("patient_ID");
            $table->string("patient_name");
            $table->string("date_of_identification");
            $table->string("category");
            $table->string("gender");
            $table->string("case_type");
            $table->string("district");
            $table->unsignedBigInteger("officer_ID")->index();

            $table->timestamps();

            $table->foreign("officer_ID")->references("officer_ID")->on("officers")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}

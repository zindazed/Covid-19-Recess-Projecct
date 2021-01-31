<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('head_patients', function (Blueprint $table) {
            $table->unsignedBigInteger("head_ID");
            $table->unsignedBigInteger("patient_ID");
            $table->primary(["head_ID","patient_ID"]);

            $table->foreign("head_ID")->references("head_ID")->on("hospitals")->onDelete("cascade");
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
        Schema::dropIfExists('head_patients');
    }
}

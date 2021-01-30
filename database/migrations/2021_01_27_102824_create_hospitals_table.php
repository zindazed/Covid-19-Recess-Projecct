<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->bigIncrements("hospital_ID");
            $table->string("hospital_name");
            $table->string("category");
            $table->string("class");
            $table->unsignedBigInteger("hospital_head")->index();
            $table->string("district");
            $table->timestamps();

            $table->foreign("hospital_head")->references("officer_ID")->on("officers")->onDelete("restrict")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospitals');
    }
}

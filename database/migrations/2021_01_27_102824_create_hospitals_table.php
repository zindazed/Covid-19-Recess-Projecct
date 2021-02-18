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
            $table->string("hospital_name");
            $table->string("category");
            $table->string("class");
            $table->string("district");

            $table->bigIncrements("head_ID");
            $table->string("head_name");
            $table->string("Email",100)->unique();
            $table->string("password");
            $table->string("officer_position");
            $table->unsignedBigInteger("administrator_ID")->index();
            $table->timestamps();

            $table->foreign("administrator_ID")->references("id")->on("users")->onDelete("restrict");


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

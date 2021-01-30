<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officers', function (Blueprint $table) {
            $table->bigIncrements("officer_ID");
            $table->string("officer_name");
            $table->boolean("waiting");
            $table->integer("monthly_payment");
            $table->integer("award_payment");
            $table->string("password");
            $table->string("officer_position");
            $table->unsignedBigInteger("head_ID")->index();
            $table->unsignedBigInteger("administrator_ID")->index();
            $table->unsignedBigInteger("hospital_ID")->index();

            $table->foreign("head_ID")->references("officer_ID")->on("officers")->onDelete("restrict");
            $table->foreign("administrator_ID")->references("administrator_ID")->on("administrators")->onDelete("restrict");
            $table->foreign("hospital_ID")->references("hospital_ID")->on("hospitals")->onDelete("cascade");
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
        Schema::dropIfExists('officers');
    }
}

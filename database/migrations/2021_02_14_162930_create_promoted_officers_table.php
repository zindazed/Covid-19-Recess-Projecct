<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotedOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promoted_officers', function (Blueprint $table) {
            $table->unsignedBigInteger("officer_ID")->primary();
            $table->string("officer_name");
            $table->string("officer_position");
            $table->string("previous_hospital");
            $table->string("new_hospital");
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
        Schema::dropIfExists('promoted_officers');
    }
}

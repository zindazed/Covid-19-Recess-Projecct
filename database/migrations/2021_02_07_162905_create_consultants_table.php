<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->unsignedBigInteger("officer_ID")->primary();
            $table->string("officer_name");
            $table->string("password");
            $table->string("officer_position");
            $table->unsignedBigInteger("head_ID")->index();
            $table->unsignedBigInteger("administrator_ID")->index();

            $table->foreign("head_ID")->references("head_ID")->on("hospitals")->onDelete("restrict");
            $table->foreign("administrator_ID")->references("id")->on("users")->onDelete("restrict");
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
        Schema::dropIfExists('consultants');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->string("Date",50)->primary();
            $table->string("Director");
            $table->string("Superintendent");
            $table->string("Administrator");
            $table->string("Officer");
            $table->string("Senior_Officer");
            $table->string("Head");
            $table->string("Paid_Consultants");
            $table->string("saved");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}

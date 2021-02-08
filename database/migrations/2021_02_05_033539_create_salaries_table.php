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
            $table->string("Date")->primary();
            $table->float("Director");
            $table->float("Superintendent");
            $table->float("Administrator");
            $table->float("Officer");
            $table->float("Senior_Officer");
            $table->float("Head");
            $table->float("Paid_Consultants");
            $table->float("saved");

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

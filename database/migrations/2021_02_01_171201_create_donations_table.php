<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements("donation_ID");
            $table->string("donation_month");
            $table->string("amount_donated");
            $table->unsignedBigInteger("donor_ID")->index();
            $table->unsignedBigInteger("administrator_ID")->index();

            $table->foreign("administrator_ID")->references("id")->on("users")->onDelete("restrict");
            $table->foreign("donor_ID")->references("donor_ID")->on("donors")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}

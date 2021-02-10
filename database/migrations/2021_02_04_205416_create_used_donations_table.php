<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsedDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('used_donations', function (Blueprint $table) {
            $table->unsignedBigInteger("donation_ID")->primary();
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
        Schema::dropIfExists('used_donations');
    }
}

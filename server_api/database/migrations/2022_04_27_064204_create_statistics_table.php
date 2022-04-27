<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->bigInteger('profit')->default(0);
            $table->bigInteger('quantitySold')->default(0);
            $table->bigInteger('quantityPurchased')->default(0);
            $table->bigInteger('newUser')->default(0);
            $table->bigInteger('paymentOnline')->default(0);
            $table->bigInteger('paymentLater')->default(0);
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
        Schema::dropIfExists('statistics');
    }
}

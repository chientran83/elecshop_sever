<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('product_id');
            $table->bigInteger('coupon_id');
            $table->bigInteger('price_total');
            $table->bigInteger('deliveryInformation_id');
            $table->bigInteger('quantity');
            $table->string('method_payment');
            $table->bigInteger('color_id');
            $table->bigInteger('tags_id');
            $table->bigInteger('memory_id');
            $table->date('date');
            $table->string('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}

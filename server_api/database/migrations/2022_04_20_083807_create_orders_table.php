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
        Schema::create('tbl_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('product_id');
            $table->bigInteger('coupon_id')->nullable();
            $table->bigInteger('price_total');
            $table->bigInteger('deliveryInformation_id');
            $table->bigInteger('quantity')->default(1);
            $table->string('method_payment')->default('postpaid');
            $table->bigInteger('color_id')->nullable();
            $table->bigInteger('tags_id')->nullable();
            $table->bigInteger('memory_id')->nullable();
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

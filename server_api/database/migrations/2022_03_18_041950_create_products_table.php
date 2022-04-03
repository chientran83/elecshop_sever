<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('current_price')->default(0);
            $table->integer('previous_price')->default(0);
            $table->integer('origin_price')->default(0);
            $table->string('image_path')->default('default.jpg');
            $table->string('ram');
            $table->string('tag');
            $table->longText('desc');
            $table->integer('isOnSale')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('user_id');
            $table->integer('category_id');
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
        Schema::dropIfExists('products');
    }
}

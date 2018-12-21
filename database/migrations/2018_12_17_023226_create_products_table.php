<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_code', 30)->unique()->primary();
            $table->unsignedInteger('user_id')->index();
            $table->string('product_name');
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->bigInteger('first_stock');
            $table->bigInteger('total_stock');
            $table->string('buy_price');
            $table->string('sell_price');
            $table->string('unit');
            $table->bigInteger('stock_in')->nullable();
            $table->bigInteger('stock_out')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
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

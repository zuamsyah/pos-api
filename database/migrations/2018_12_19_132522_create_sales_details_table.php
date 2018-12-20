<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_id')->index();
            $table->string('product_code',30)->index();
            $table->bigInteger('product_amount');
            $table->bigInteger('sell_price');
            $table->string('subtotal_price')->default(0);
            $table->timestamps();
            $table->foreign('product_code')->references('product_code')->on('products');
            $table->foreign('sales_id')->references('sales_id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_details');
    }
}

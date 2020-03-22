<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('sellers');
            $table->integer('seller_delivery_id')->unsigned();
            $table->foreign('seller_delivery_id')->references('id')->on('sellers');
            $table->integer('day_sale_id')->unsigned();
            $table->foreign('day_sale_id')->references('id')->on('day_sales');
            $table->tinyInteger('type_pay');
            $table->text('fruits');
            $table->text('pays')->nullable();
            $table->double('total');
            $table->double('pay');
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
        Schema::dropIfExists('sales');
    }
}

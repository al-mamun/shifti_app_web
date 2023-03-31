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
            $table->string('order_number')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('shipping_status_id')->nullable();
            $table->unsignedBigInteger('payment_status_id')->nullable();
            $table->unsignedBigInteger('shipping_method_id')->nullable();
            $table->string('track_number')->nullable();
            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('address_id')->references('id')->on('addresses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('shipping_status_id')->references('id')->on('shipping_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_type_id')->references('id')->on('product_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->cascadeOnUpdate()->cascadeOnDelete();
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

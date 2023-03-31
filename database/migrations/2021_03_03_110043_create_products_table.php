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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('product_name')->nullable();
            $table->text('slug')->nullable();
            $table->string('slug_id')->nullable();
            $table->longText('description')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('price')->nullable();
            $table->integer('product_cost')->nullable();
            $table->tinyInteger('discount_type')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->timestamp('discount_time')->nullable();
            $table->string('sku')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('parent')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('order_by')->nullable();
            $table->integer('product_origin')->nullable();
            $table->unsignedBigInteger('product_type_id'); //regular, grocery , global
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->tinyInteger('type')->nullable(); //child or parent
            $table->string('variation_product')->nullable();
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

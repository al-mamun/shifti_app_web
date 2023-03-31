<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('customer_id');
            $table->tinyInteger('is_liked')->default(0)->comment('1 = liked, 0 not liked');
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands')->restrictOnUpdate()->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->restrictOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_likes');
    }
}

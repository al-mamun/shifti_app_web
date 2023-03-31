<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foreign_key')->nullable();
            $table->integer('applied_to')->nullable()->comment('1. All product, 2. Category, 3. Sub category, 4. Product');
            $table->string('code')->nullable();
            $table->date('expire_date')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('discount_type')->nullable()->comment('1. Percent , 2. Flat Amount');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}

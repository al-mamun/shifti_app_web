<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->nullable();
            $table->integer('parent')->nullable();
            $table->integer('level')->nullable();
            $table->string('slug')->nullable();
            $table->string('slug_id')->nullable();
            $table->string('icon')->nullable();
            $table->string('feature_photo')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('order_by')->nullable();
            $table->unsignedBigInteger('product_type_id');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('categories');
    }
}

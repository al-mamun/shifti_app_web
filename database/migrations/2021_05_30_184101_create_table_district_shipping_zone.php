<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDistrictShippingZone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_shipping_zone', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('district_id');
           $table->unsignedBigInteger('shipping_zone_id');
           $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete()->cascadeOnUpdate();
           $table->foreign('shipping_zone_id')->references('id')->on('shipping_zones')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('district_shipping_zone', function (Blueprint $table) {
            //
        });
    }
}

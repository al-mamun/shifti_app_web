<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable()->comment('api status code');
            $table->string('status_text')->nullable()->comment('api status text');
            $table->string('message_id')->nullable()->comment('api message sent id');
            $table->string('message_text')->nullable()->comment('message body');
            $table->string('number')->nullable()->comment('sms receiver number');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('type')->nullable()->comment('campaign or other');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('s_m_s');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'payment_id', 'user_id', 'status'
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payment_id');
            $table->integer('user_id');
            $table->integer('total_price');
            $table->string('coupon');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}

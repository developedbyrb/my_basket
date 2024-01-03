<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('expected_delivery_date')->nullable();
            $table->tinyInteger('payment_type')->default(1)
                ->comment('1=>COD, 2=>Card, 3=>UPI, 4=>Net Banking');
            $table->integer('qty');
            $table->integer('total_amount');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_by');
            $table->tinyInteger('status')->default(1)
                ->comment('1=>Placed, 2=>In Transits, 3=>Delivered, 4=>Cancelled');
            $table->string('cancelled_reason')->nullable();
            $table->string('cancelled_reason_image')->nullable();
            $table->timestamps();
            $table->foreign('shop_id')->references('id')->on('shops')
                ->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('order_by')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

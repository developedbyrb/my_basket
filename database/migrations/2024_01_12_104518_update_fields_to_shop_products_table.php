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
        Schema::table('shop_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->renameColumn('product_id', 'sku_id');
            $table->renameColumn('price', 'selling_price');
            $table->foreign('sku_id')->references('id')->on('skus')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->dropForeign(['sku_id']);
            $table->renameColumn('sku_id', 'product_id');
            $table->renameColumn('selling_price', 'price');
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
        });
    }
};

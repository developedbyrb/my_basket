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
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['shop_id']);
            $table->renameColumn('product_id', 'sku_id');
            $table->unsignedBigInteger('shop_id')->nullable()->change();
            $table->foreign('sku_id')->references('id')->on('skus')
                ->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['sku_id']);
            $table->dropForeign(['shop_id']);
            $table->renameColumn('sku_id', 'product_id');
            $table->unsignedBigInteger('shop_id')->change();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')
                ->onDelete('cascade');
        });
    }
};

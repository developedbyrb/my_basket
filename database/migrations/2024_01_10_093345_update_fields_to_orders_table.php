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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropForeign(['product_id']);
            $table->unsignedBigInteger('shop_id')->nullable()->change();
            $table->renameColumn('product_id', 'sku_id');
            $table->unsignedBigInteger('warehouse_id')->nullable()->after('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')
                ->onDelete('cascade');
            $table->foreign('sku_id')->references('id')->on('skus')
                ->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn('warehouse_id');
            $table->dropForeign(['sku_id']);
            $table->renameColumn('sku_id', 'product_id');
            $table->unsignedBigInteger('shop_id')->change();
            $table->foreign('shop_id')->references('id')->on('shops')
                ->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
        });
    }
};

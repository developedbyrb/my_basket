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
        Schema::table('shop_addresses', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->unsignedBigInteger('shop_id')->nullable()->change();
            $table->unsignedBigInteger('warehouse_id')->nullable()->after('shop_id');
            $table->string('alias')->nullable()->after('warehouse_id');
            $table->boolean('is_default')->default(0)->after('alias');
            $table->foreign('shop_id')->references('id')->on('shops')
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
        Schema::table('skus', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropForeign(['warehouse_id']);
            $table->dropColumn('alias');
            $table->dropColumn('is_default');
            $table->dropColumn('warehouse_id');
            $table->unsignedBigInteger('shop_id')->change();
            $table->foreign('shop_id')->references('id')->on('shops')
                ->onDelete('cascade');
        });
    }
};

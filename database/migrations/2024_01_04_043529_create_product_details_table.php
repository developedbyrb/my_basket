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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('brand');
            $table->string('price');
            $table->string('weight');
            $table->tinyInteger('return_policy')->default(0)->comment('[0=>None, 1=>7Days, 2=>10ays, 3=>15Days]');
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('breadth')->nullable();
            $table->string('ships_from')->nullable();
            $table->string('ship_by')->nullable();
            $table->string('import_fees')->nullable();
            $table->tinyInteger('state')->default(0)->comment('[0=>New, 1=>Refurbished]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};

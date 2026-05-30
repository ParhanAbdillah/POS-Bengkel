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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('sku', 50)->unique();
            $table->string('name_sparepart', 50);
            $table->string('brand_sparepart', 30);
            $table->integer('stock_sparepart')->default(0);
            $table->integer('min_stock_sparepart')->default(5);
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('selling_price', 15, 2);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};

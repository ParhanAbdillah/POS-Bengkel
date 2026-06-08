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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('mechanic_id')->constrained('mechanics');
            $table->string('service_category')->nullable();
            $table->string('complaint')->nullable();
            $table->string('vehicle_condition')->nullable();
            $table->integer('current_km')->nullable();
            $table->decimal('dp', 15, 2)->default(0);
            
            $table->decimal('total_service_price', 15, 2)->default(0);
            $table->decimal('total_sparepart_price', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('money_paid', 15, 2)->default(0);
            $table->decimal('money_change', 15, 2)->default(0);
            $table->enum('status', ['antre', 'proses', 'menunggu_sparepart', 'bisa_diambil', 'selesai', 'cancel'])->default('antre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

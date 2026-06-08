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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('mechanic_id')->nullable()->change();
            $table->string('service_type')->nullable()->after('service_category');
            $table->text('description')->nullable()->after('complaint');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('mechanic_id')->nullable(false)->change();
            $table->dropColumn('service_type');
            $table->dropColumn('description');
        });
    }
};

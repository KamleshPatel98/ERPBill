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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('hsn_code', 10)->nullable();
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('gst_id')->constrained()->onDelete('cascade');
            $table->decimal('mrp', 15, 2)->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('opening_stock', 15, 2)->default(0);
            $table->boolean('is_active')->default(true)->comment('1: Active, 0: Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_return_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 15, 2)->default(0);       
            $table->decimal('quantity', 15, 2)->default(0);     
            $table->decimal('sub_total', 15, 2)->default(0);    // sub_total = price × quantity
            $table->decimal('discount', 15, 2)->default(0);     // net_before_tax = sub_total - discount
            $table->foreignId('gst_id')->nullable()->constrained()->onDelete('set null'); // Example: 4 (GST 18%)
            $table->decimal('gst_rate', 5, 2)->default(0);      // Example: 18%
            $table->decimal('gst_amount', 15, 2)->default(0);  // gst_amount = (net_before_tax × gst_rate) / 100
            $table->decimal('total', 15, 2)->default(0);        // total = net_before_tax + gst_amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_return_items');
    }
};

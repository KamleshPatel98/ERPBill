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
        Schema::create('gsts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique();
            $table->decimal('rate', 5, 2);
            $table->boolean('is_active')->default(true)->comment('1: Active, 0: Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gsts');
    }
};

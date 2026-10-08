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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('details')->nullable(); // 👈 Added missing details column here
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);

            // Multiple image columns
            $table->string('image')->nullable();   // main image
            $table->string('image1')->nullable();  // extra image 1
            $table->string('image2')->nullable();  // extra image 2
            $table->string('image3')->nullable();  // extra image 3
            $table->string('image4')->nullable();  // extra image 4

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
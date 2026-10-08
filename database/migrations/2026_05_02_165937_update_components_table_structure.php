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
        // 1. If the components table doesn't exist, create it from scratch
        if (!Schema::hasTable('components')) {
            Schema::create('components', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->string('category');
                $table->decimal('price', 10, 2)->nullable();
                $table->json('specs')->nullable();
                $table->integer('tier')->default(1);
                $table->timestamps();
            });

            return;
        }

        // 2. If the table already exists, safely add/update missing columns
        Schema::table('components', function (Blueprint $table) {
            if (Schema::hasColumn('components', 'id')) {
                $table->string('id')->change();
            }

            if (!Schema::hasColumn('components', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('components', 'category')) {
                $table->string('category')->after('name');
            }

            if (!Schema::hasColumn('components', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('components', 'specs')) {
                $table->json('specs')->nullable();
            }

            if (!Schema::hasColumn('components', 'tier')) {
                $table->integer('tier')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
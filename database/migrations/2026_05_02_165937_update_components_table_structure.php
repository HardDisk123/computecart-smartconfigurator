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
        Schema::table('components', function (Blueprint $table) {

            // ✅ FIX: make sure id is STRING (IMPORTANT FOR YOUR SEEDER)
            if (Schema::hasColumn('components', 'id')) {
                $table->string('id')->change();
            }

            // ✅ Add missing columns safely
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
        Schema::table('components', function (Blueprint $table) {

            $table->dropColumn(['name', 'category', 'price', 'specs', 'tier']);

            // optional rollback (only if needed)
            // $table->unsignedBigInteger('id')->change();
        });
    }
};
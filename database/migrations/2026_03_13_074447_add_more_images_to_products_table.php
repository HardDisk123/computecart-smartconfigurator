<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add category_id if missing
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->after('stock');
                $table->foreign('category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('cascade');
            }

            // Add image columns if missing
            foreach (['image','image1','image2','image3','image4'] as $field) {
                if (!Schema::hasColumn('products', $field)) {
                    $table->string($field)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            $table->dropColumn(['image','image1','image2','image3','image4']);
        });
    }
};

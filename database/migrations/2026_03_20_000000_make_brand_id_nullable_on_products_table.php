<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the existing FK so we can alter the column
            $table->dropForeign(['brand_id']);

            // Allow products to exist without a brand
            $table->unsignedBigInteger('brand_id')->nullable()->change();

            // Recreate foreign key to null on delete
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);

            $table->unsignedBigInteger('brand_id')->nullable(false)->change();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->cascadeOnDelete();
        });
    }
};

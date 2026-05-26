<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('order_items', function (Blueprint $table) {
        
        // Chỉ thêm cột nếu chưa tồn tại
        if (!Schema::hasColumn('order_items', 'product_name')) {
            $table->string('product_name')->nullable()->after('product_variant_id');
        }

        if (!Schema::hasColumn('order_items', 'variant_name')) {
            $table->string('variant_name')->nullable();
        }

        if (!Schema::hasColumn('order_items', 'size_name')) {
            $table->string('size_name')->nullable();
        }

        if (!Schema::hasColumn('order_items', 'color_name')) {
            $table->string('color_name')->nullable();
        }

        if (!Schema::hasColumn('order_items', 'product_image')) {
            $table->string('product_image')->nullable();
        }

        if (!Schema::hasColumn('order_items', 'attributes')) {
            $table->json('attributes')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
};

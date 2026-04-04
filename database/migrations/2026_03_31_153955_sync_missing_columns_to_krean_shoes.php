<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cập nhật bảng users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->boolean('status')->default(1)->after('password');
            }
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // 2. Cập nhật bảng categories
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('categories', 'status')) {
                $table->boolean('status')->default(1)->after('description');
            }
        });

        // 3. Cập nhật bảng products
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'sort_des')) {
                $table->text('sort_des')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('products', 'quantity')) {
                $table->unsignedInteger('quantity')->default(0)->after('description');
            }
            if (!Schema::hasColumn('products', 'date_of_entry')) {
                $table->datetime('date_of_entry')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('products', 'view')) {
                $table->unsignedInteger('view')->default(0)->after('status');
            }
        });

        // 4. Cập nhật bảng product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            if (!Schema::hasColumn('product_variants', 'attribute_name')) {
                $table->string('attribute_name')->nullable()->after('sku');
            }
            if (!Schema::hasColumn('product_variants', 'image')) {
                $table->string('image')->nullable()->after('attribute_name');
            }
            if (!Schema::hasColumn('product_variants', 'status')) {
                $table->boolean('status')->default(1)->after('stock');
            }
        });

        // 5. Cập nhật bảng order_items (Lưu log chi tiết như Greenhome)
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'product_name')) {
                $table->string('product_name')->nullable()->after('order_id');
            }
            if (!Schema::hasColumn('order_items', 'product_variant_sku')) {
                $table->string('product_variant_sku')->nullable()->after('product_name');
            }
            if (!Schema::hasColumn('order_items', 'product_image')) {
                $table->string('product_image')->nullable()->after('product_variant_sku');
            }
            if (!Schema::hasColumn('order_items', 'product_attribute')) {
                $table->string('product_attribute')->nullable()->after('product_image');
            }
            if (!Schema::hasColumn('order_items', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('price');
            }
            if (!Schema::hasColumn('order_items', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        // Viết logic dropColumn tương ứng nếu bạn cần rollback
    }
};
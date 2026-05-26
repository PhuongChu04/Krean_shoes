<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            
            // Cho phép null khi variant/sản phẩm bị xóa mềm
            $table->foreignId('product_variant_id')
                  ->nullable()
                  ->constrained('product_variants')
                  ->onDelete('set null')
                  ->change();

            // === THÊM CÁC CỘT SNAPSHOT (rất quan trọng) ===
            $table->string('product_name');                    // Tên sản phẩm lúc mua
            $table->string('variant_name')->nullable();        // Ví dụ: "Nike Air - Đen - 42"
            $table->string('image')->nullable();               // Ảnh sản phẩm lúc mua
            $table->json('attributes')->nullable();            // Lưu size, color, ...

            // Index để tìm kiếm nhanh
            $table->index(['order_id', 'product_variant_id']);
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'variant_name', 'image', 'attributes']);
            
            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->onDelete('restrict')
                  ->change();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cart_id')
                  ->constrained('carts')
                  ->cascadeOnDelete();  // xóa giỏ thì xóa luôn items

            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->onDelete('restrict');  // không cho xóa variant nếu đang có trong giỏ

            $table->integer('quantity')->unsigned()->default(1);

            $table->decimal('price', 12, 2)->nullable()
                  ->comment('giá snapshot lúc thêm vào giỏ');

            $table->timestamps();
            // không cần softDeletes vì đây là dữ liệu tạm thời
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
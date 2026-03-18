<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->onDelete('restrict');

            $table->integer('quantity')->unsigned();
            $table->decimal('price', 12, 2);     // giá lúc đặt hàng
            $table->decimal('subtotal', 12, 2);  // quantity × price

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->string('order_code', 50)->unique();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            $table->enum('status', [
                'pending', 'confirmed', 'processing', 'shipped',
                'delivered', 'cancelled', 'returned'
            ])->default('pending');

            $table->enum('payment_method', ['cod', 'bank', 'momo', 'vnpay', 'card'])->default('cod');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');

            $table->string('receiver_name', 100);
            $table->string('receiver_phone', 20);
            $table->text('receiver_address');
            $table->string('receiver_ward', 100)->nullable();
            $table->string('receiver_district', 100)->nullable();
            $table->string('receiver_province', 100)->nullable();

            $table->text('note')->nullable();         // ghi chú khách
            $table->text('admin_note')->nullable();   // ghi chú nội bộ

            $table->foreignId('voucher_id')
                  ->nullable()
                  ->constrained('vouchers')
                  ->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
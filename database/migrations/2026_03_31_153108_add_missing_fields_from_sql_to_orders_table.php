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
        Schema::table('orders', function (Blueprint $table) {
            // Bổ sung các trường từ file SQL gốc
            $table->string('user_name')->after('user_id');
            $table->datetime('delivery_at')->nullable()->after('status');
            $table->text('cancel_reason')->nullable()->after('note');

            // Bổ sung kiểu giảm giá nếu bạn muốn quản lý chi tiết như SQL
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable()->after('discount_amount');

            // Đổi tên cột nếu bạn muốn khớp hoàn toàn với SQL (Tùy chọn)
            // $table->renameColumn('order_code', 'sku');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['user_name', 'delivery_at', 'cancel_reason', 'discount_type']);
        });
    }
};

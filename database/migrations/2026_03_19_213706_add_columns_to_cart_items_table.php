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
        Schema::table('cart_items', function (Blueprint $table) {
            // 1. Đổi tên 'price' thành 'unit_price' cho giống file gốc
            if (Schema::hasColumn('cart_items', 'price')) {
                $table->renameColumn('price', 'unit_price');
            }

            // 2. Thêm các trường thiếu từ file 3
            $table->decimal('total_price', 10, 2)->after('quantity');
            $table->text('note')->nullable()->after('total_price');

            // 3. Thêm SoftDeletes vì file 2 đang thiếu
            if (!Schema::hasColumn('cart_items', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->renameColumn('unit_price', 'price');
            $table->dropColumn(['total_price', 'note', 'deleted_at']);
        });
    }
};

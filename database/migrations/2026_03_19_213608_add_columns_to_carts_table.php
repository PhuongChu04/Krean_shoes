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
        Schema::table('carts', function (Blueprint $table) {
            // Bổ sung các trường từ file 4
            $table->decimal('total_amount', 10, 2)->default(0)->after('user_id');
            $table->text('note')->nullable()->after('total_amount');

            // Nếu bạn muốn ép user_id là duy nhất như file gốc
            $table->unique('user_id'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'note']);
        });
    }
};

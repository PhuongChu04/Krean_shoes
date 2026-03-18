<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');  // nếu user xóa thì giỏ cũng xóa

            $table->string('guest_token', 60)->nullable()->unique()
                  ->comment('cho khách vãng lai, lưu trong cookie');

            $table->timestamps();
            $table->softDeletes();  // có thể xóa giỏ cũ (abandoned cart)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Tương đương: `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            
            $table->string('content', 255);
            $table->enum('status', ['chưa duyệt', 'hiển thị', 'ẩn'])->default('chưa duyệt');
            
            $table->timestamps(); // Tự động tạo 2 cột `created_at` và `updated_at` (timestamp NULL)
            $table->softDeletes(); // Tự động tạo cột `deleted_at` (timestamp NULL)

            // Lưu ý (Tùy chọn): Nếu bạn muốn thiết lập khóa ngoại (Foreign Keys) luôn thì có thể mở comment 2 dòng dưới
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};

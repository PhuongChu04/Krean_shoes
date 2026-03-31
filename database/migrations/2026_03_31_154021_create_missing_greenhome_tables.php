<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Module Profile & Web Info
        if (!Schema::hasTable('user_profiles')) {
            Schema::create('user_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('phone', 20)->nullable()->unique();
                $table->text('address')->nullable();
                $table->enum('gender', ['nam', 'nu', 'khac'])->default('khac');
                $table->date('birth_date')->nullable();
                $table->string('user_image')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('web_infos')) {
            Schema::create('web_infos', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        // 2. Module UI / Content
        if (!Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->enum('type', ['slider', 'category_banner', 'discount_banner'])->default('slider');
                $table->string('name')->nullable();
                $table->string('img')->nullable();
                $table->text('description')->nullable();
                $table->string('link')->nullable();
                $table->integer('priority')->default(0);
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->text('answer');
                $table->timestamps();
            });
        }

        // 3. Module Blogs
        if (!Schema::hasTable('blog_categories')) {
            Schema::create('blog_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('summary')->nullable();
                $table->longText('content');
                $table->string('thumbnail')->nullable();
                $table->boolean('status')->default(1);
                $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('blog_category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 4. Module Tương tác (Review, Wishlist)
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('order_item_id')->nullable()->constrained('order_items')->cascadeOnDelete();
                $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
                $table->tinyInteger('rating');
                $table->string('title', 150);
                $table->text('content');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('review_images')) {
            Schema::create('review_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('review_id')->constrained('reviews')->cascadeOnDelete();
                $table->string('image');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wishlists')) {
            Schema::create('wishlists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->date('add_at');
                $table->boolean('notify_on_sale')->default(0);
                $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
                $table->softDeletes();
            });
        }

        // 5. Module Hoàn tiền (Refund)
        if (!Schema::hasTable('refund_transactions')) {
            Schema::create('refund_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->text('refund_reason')->nullable();
                $table->string('refund_image')->nullable();
                $table->enum('refund_status', ['pending', 'approved', 'rejected', 'refund_pending', 'account_invalid', 'refunded'])->default('pending');
                $table->string('refund_account_name')->nullable();
                $table->string('refund_account_bank')->nullable();
                $table->string('refund_account_number')->nullable();
                $table->string('refund_account_qr')->nullable();
                $table->decimal('refund_cost', 12, 2)->nullable();
                $table->string('refund_proof_image')->nullable();
                $table->datetime('refund_date')->nullable();
                $table->text('admin_note')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_transactions');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('review_images');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('web_infos');
        Schema::dropIfExists('user_profiles');
    }
};
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
    Schema::table('reviews', function (Blueprint $table) {
        $table->text('reply')->nullable()->after('content');           // Phản hồi của admin
        $table->timestamp('replied_at')->nullable()->after('reply');   // Thời gian phản hồi
        $table->foreignId('replied_by')->nullable()->constrained('users'); // Admin nào phản hồi
    });
}

public function down(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->dropColumn(['reply', 'replied_at', 'replied_by']);
    });
}
};

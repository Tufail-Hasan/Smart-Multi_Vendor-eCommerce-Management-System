<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_ratings', function (Blueprint $table) {
            $table->id();

            // Product and Customer
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            // Rating and Review
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('review')->nullable();

            // Review Images
            $table->json('images')->nullable();

            // Verification
            $table->boolean('is_verified_purchase')->default(false);

            // Moderation
            $table->string('status')->default('pending');

            // Admin Reply
            $table->text('admin_reply')->nullable();

            $table->foreignId('replied_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('replied_at')->nullable();

            // Engagement
            $table->unsignedInteger('helpful_count')->default(0);
            $table->unsignedInteger('report_count')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'status']);
            $table->index(['customer_id', 'status']);
            $table->index('rating');
            $table->index('is_verified_purchase');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_ratings');
    }
};

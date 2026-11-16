<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            // Reviewed Product
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            // Customer who submitted the review
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Review Information
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('review');

            // Purchase Verification
            $table->boolean('is_verified_purchase')->default(false);

            // Moderation
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            $table->text('admin_reply')->nullable();
            $table->foreignId('moderated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('moderated_at')->nullable();

            // Helpful votes
            $table->unsignedInteger('helpful_count')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['rating', 'status']);

            // One review per customer per product
            $table->unique(['product_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};

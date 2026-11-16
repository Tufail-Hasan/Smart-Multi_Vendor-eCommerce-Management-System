<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();

            // Order Relationship
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Status Information
            $table->string('previous_status')->nullable();

            $table->string('status');

            // Status Change Information
            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('comment')->nullable();

            $table->timestamp('changed_at')->useCurrent();

            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'changed_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};

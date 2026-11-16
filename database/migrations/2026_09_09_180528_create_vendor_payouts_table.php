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
        Schema::create('vendor_payouts', function (Blueprint $table) {
            $table->id();

            // Vendor
            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->cascadeOnDelete();

            // Admin/User who processed the payout
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Payout amount
            $table->decimal('amount', 12, 2);

            // Commission deducted by platform
            $table->decimal('commission', 12, 2)
                ->default(0);

            // Final amount vendor receives
            $table->decimal('net_amount', 12, 2);

            // Payment method
            $table->enum('payment_method', [
                'bank',
                'bkash',
                'nagad',
                'rocket',
                'paypal',
                'stripe',
                'other',
            ])->default('bank');

            // Payment account/details
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();

            // Transaction information
            $table->string('transaction_id')->nullable()->unique();
            $table->string('reference_number')->nullable();

            // Payout status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
            ])->default('pending');

            // Admin/vendor notes
            $table->text('note')->nullable();
            $table->text('rejection_reason')->nullable();

            // Dates
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Useful indexes
            $table->index(['vendor_id', 'status']);
            $table->index('payment_method');
            $table->index('requested_at');
            $table->index('processed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_payouts');
    }
};

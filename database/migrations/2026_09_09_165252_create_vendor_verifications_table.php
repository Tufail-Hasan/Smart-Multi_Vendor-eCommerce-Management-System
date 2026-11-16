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
        Schema::create('vendor_verifications', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Vendor
            |--------------------------------------------------------------------------
            */
            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Business Information
            |--------------------------------------------------------------------------
            */
            $table->string('business_name');

            $table->string('business_type')
                ->nullable();

            $table->string('business_registration_number')
                ->nullable();

            $table->string('tax_id')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Owner Information
            |--------------------------------------------------------------------------
            */
            $table->string('owner_name');

            $table->string('owner_phone')
                ->nullable();

            $table->string('owner_email')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Verification Documents
            |--------------------------------------------------------------------------
            */
            $table->string('business_license')
                ->nullable();

            $table->string('tax_document')
                ->nullable();

            $table->string('identity_document')
                ->nullable();

            $table->string('address_proof')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Verification Status
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'pending',
                'under_review',
                'approved',
                'rejected',
                'revision_required',
            ])->default('pending');


            /*
            |--------------------------------------------------------------------------
            | Verification Dates
            |--------------------------------------------------------------------------
            */
            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamp('reviewed_at')
                ->nullable();

            $table->timestamp('verified_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Reviewer
            |--------------------------------------------------------------------------
            */
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Review Information
            |--------------------------------------------------------------------------
            */
            $table->text('rejection_reason')
                ->nullable();

            $table->text('admin_notes')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */
            $table->index('status');
            $table->index('submitted_at');
            $table->index('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_verifications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_snapshots', function (Blueprint $table) {
            $table->id();

            $table->string('report_type');
            $table->string('title');

            // Report filters, such as date range
            $table->json('filters')->nullable();

            // Saved report results
            $table->json('report_data');

            $table->string('format')->default('json');
            $table->timestamp('generated_at')->nullable();

            $table->foreignId('generated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['report_type', 'generated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_snapshots');
    }
};

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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->unsignedBigInteger('agent');
            $table->string('address')->nullable();
            $table->date('closing_data')->nullable();
            $table->boolean('is_co_listing')->default(false);
            $table->unsignedBigInteger('co_agent')->nullable();
            $table->enum('represent', ['buyer', 'seller', 'both'])->default('buyer');
            $table->date('date_listed')->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->date('contract_data')->nullable();
            $table->decimal('commision_percentage')->nullable();
            $table->decimal('co_agent_percentage')->nullable();
            $table->decimal('referral_percentage')->nullable();
            $table->foreignId('property_source_id')->nullable()->constrained('property_sources')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('comment')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('agent')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('co_agent')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};

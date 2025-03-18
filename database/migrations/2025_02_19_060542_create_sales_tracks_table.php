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
        Schema::create('sales_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('track_id')->unique();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->enum('status', ['active', 'pending', 'close', 'expired'])->default('active');
            $table->date('date_under_contract');
            $table->date('closing_date');
            $table->decimal('purchase_price');
            $table->string('buyer_seller')->nullable();
            $table->decimal('referral_fee_pct');
            $table->decimal('commission_on_sale');
            $table->decimal('override_split')->default(0)->nullable();
            $table->longText('note');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_tracks');
    }
};

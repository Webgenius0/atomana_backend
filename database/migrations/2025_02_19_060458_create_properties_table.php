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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->unsignedBigInteger('agent');
            $table->string('sku')->unique();
            $table->string('email');
            $table->string('address');
            $table->decimal('price');
            $table->date('expiration_date');
            $table->boolean('is_development')->default(false);
            $table->boolean('add_to_website')->default(false);
            $table->boolean('is_co_listing')->default(false);
            $table->unsignedBigInteger('co_agent')->nullable();
            $table->decimal('commission_rate', 15, 2)->nullable();;
            $table->decimal('co_list_percentage', 15, 2)->nullable();;
            $table->foreignId('property_source_id')->nullable()->constrained('property_sources')->nullOnDelete();

            $table->integer('beds')->nullable();
            $table->integer('full_baths')->nullable();
            $table->integer('half_baths')->nullable();
            $table->decimal('size')->nullable();
            $table->string('link')->nullable();
            $table->longText('note')->nullable();

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
        Schema::dropIfExists('properties');
    }
};

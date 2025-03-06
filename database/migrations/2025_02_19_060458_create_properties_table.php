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
            $table->string('email');
            $table->string('address');
            $table->decimal('price', 15, 2);
            $table->date('expiration_date');
            $table->boolean('development');
            $table->unsignedBigInteger('co_agent')->nullable();
            $table->decimal('co_list_percentage', 5, 2);
            $table->string('source');
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

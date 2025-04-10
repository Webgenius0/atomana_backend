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
        Schema::create('property_access_instructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('property_type_id')->constrained('property_types')->cascadeOnDelete();
            $table->string('size')->nullable();
            $table->string('access_key')->nullable();
            $table->string('lock_box_location')->nullable();
            $table->string('pickup_instructions')->nullable();
            $table->string('gate_code')->nullable();
            $table->string('gete_access_location')->nullable();
            $table->string('visitor_parking')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_access_instructions');
    }
};

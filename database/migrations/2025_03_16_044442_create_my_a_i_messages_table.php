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
        Schema::create('my_a_i_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('my_a_i_id')->constrained('my_a_i_s')->cascadeOnDelete();
            $table->longText('message');
            $table->longText('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_a_i_messages');
    }
};

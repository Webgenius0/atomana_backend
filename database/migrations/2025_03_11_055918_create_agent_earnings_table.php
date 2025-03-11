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
        Schema::create('agent_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('sales_closed');
            $table->decimal('closed_sales_total');
            $table->decimal('percentage_of_closed_deals');
            $table->decimal('agent_commision_spit');
            $table->decimal('gross_commision');
            $table->decimal('compass_cut');
            $table->decimal('net_commision');
            $table->decimal('total_net_commision');
            $table->decimal('agent_net_income');
            $table->decimal('total_agent_net_income');
            $table->decimal('spears_group_gross_income');
            $table->decimal('sg_net_income');
            $table->decimal('total_sg_net_income');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_earnings');
    }
};

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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('expense_for_id')->constrained('expense_fors')->cascadeOnDelete();

            $table->foreignId('expense_category_id')->nullable()->constrained('expense_categories')->nullOnDelete();
            $table->foreignId('expense_sub_category_id')->nullable()->constrained('expense_sub_categories')->nullOnDelete();

            $table->longText('description')->nullable();
            $table->float('amount')->nullable();

            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->cascadeOnDelete();

            $table->string('payee')->nullable();
            $table->string('recept_name')->nullable();
            $table->string('recept_url')->nullable();
            $table->boolean('reimbursable')->nullable();
            $table->string('listing')->nullable();
            $table->longText('note')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('archive')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

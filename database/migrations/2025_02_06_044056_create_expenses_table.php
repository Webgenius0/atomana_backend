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
            $table->foreignId('expense_for_id')->constrained('expense_fors')->cascadeOnDelete();
            $table->foreignId('expense_type_id')->constrained('expense_types')->cascadeOnDelete();
            $table->foreignId('expense_category_id')->constrained('expense_categories')->cascadeOnDelete();
            $table->foreignId('expense_sub_category_id')->constrained('expense_sub_categories')->cascadeOnDelete();
            $table->longText('description');
            $table->float('amount');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('recept_name');
            $table->string('recept_url')->nullable();
            $table->string('owner');
            $table->boolean('reimbursable');
            $table->string('listing');
            $table->longText('note');
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

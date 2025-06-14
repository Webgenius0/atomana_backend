<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseSubCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at'          => 'datetime',
            'updated_at'          => 'datetime',
            'expense_category_id' => 'integer',
        ];
    }

    // ------------------------------------
    // ------------------------------------

    /**
     * Model relationship with Expense
     * @return HasMany<Expense, ExpenseSubCategory>
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }


    /**
     * Model relationship with Expense
     * @return BelongsTo<ExpenseCategory, ExpenseSubCategory>
     */
    public function expenseCategory():BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}

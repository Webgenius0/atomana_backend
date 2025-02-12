<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ------------------------------------
    // ------------------------------------

    /**
     * Model relationship with Expense
     * @return HasMany<Expense, ExpenseCategory>
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }


    /**
     * Modelk relsaton with ExpenseSubCategory
     *
     * @return HasMany<ExpenseSubCategory, ExpenseCategory>
     */
    public function expenseSubCategory(): HasMany
    {
        return $this->hasMany(ExpenseSubCategory::class);
    }
}

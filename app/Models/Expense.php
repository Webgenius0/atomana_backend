<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
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
            'id' => 'integer',
            'business_id' => 'integer',
            'expense_for_id' => 'integer',
            'expense_category_id' => 'integer',
            'expense_sub_category_id' => 'integer',
            'amount' => 'float',
            'payment_method_id' => 'integer',
            'reimbursable' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }


    // ------------------------------------
    // ------------------------------------

    /**
     * belongs to expenseCategory
     * @return BelongsTo<ExpenseCategory, Expense>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }


    /**
     * belongs to expenseSubCategory
     * @return BelongsTo<ExpenseSubCategory, Expense>
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseSubCategory::class, 'expense_sub_category_id');
    }

    /**
     * belongs to expenseFor
     * @return BelongsTo<ExpenseFor, Expense>
     */
    public function for(): BelongsTo
    {
        return $this->belongsTo(ExpenseFor::class);
    }

    /**
     * belongs to paymentMethord
     * @return BelongsTo<PaymentMethod, Expense>
     */
    public function paymentMethord(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /**
     * belongs to user
     * @return BelongsTo<PaymentMethod, Expense>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * acccessor for recept_url attribute
     * @param string
     */
    protected function getReceptUrlAttribute($url): string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('storage/' . $url);
            }
        } else {
            return asset('assets/img/404.png');
        }
    }

    /**
     * acccessor for Amount Attribute
     * @param mixed $value
     * @return string
     */
    protected function getAmountAttribute($value): string
    {
        return number_format($value, 2, '.', '');
    }

    /**
     * accessor for created_at
     * @param mixed $value
     * @return string
     */
    protected function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

// Through business_user → business
/**
 * belongs to expenseFor
 * @return BelongsTo<ExpenseFor, Expense>
 */
    public function expenseFor()
    {
        return $this->belongsTo(ExpenseFor::class, 'expense_for_id');
    }
    /**
     * belongs to expenseCategory
     * @return BelongsTo<ExpenseCategory, Expense>
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
    /**
     * belongs to business
     * @return BelongsTo<Business, Expense>
     */

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}

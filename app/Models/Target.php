<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id'         => 'integer',
            'user_id'    => 'integer',
            'amount'     => 'float',
            'month'      => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }


    /**
     * acccessor for Amount Attribute
     * @param mixed $value
     * @return string
     */
    protected function getAmountAttribute($value): string
    {
        return  number_format($value, 2, '.', '');
    }


    /**
     * accessor for month
     * @param mixed $value
     * @return string
     */
    protected function getMonthAttribute($value): string
    {
        return Carbon::parse($value)->format('m/Y');
    }

    // _____________________________
    // _____________________________

    /**
     * Model Belongs To User Model.
     * @return BelongsTo<User, VendorReview>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

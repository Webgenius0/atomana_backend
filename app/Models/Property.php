<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
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
            'id'              => 'integer',
            'business_id'     => 'integer',
            'user_id'         => 'integer',
            'price'           => 'float',
            'created_at'      => 'datetime',
            'updated_at'      => 'datetime',
        ];
    }

    /**
     *  acccessor for Price Attribute
     * @param mixed $value
     * @return string
     */
    protected function getPriceAttribute($value): string
    {
        return  number_format($value, 2, '.', '');
    }

    // ------------------------------------
    // ------------------------------------

    /**
     * Belongs to User Model.
     * @return BelongsTo<User, Property>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * belongs to Property Model.
     * @return BelongsTo<Business, Property>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}

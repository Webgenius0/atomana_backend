<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorReview extends Model
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
     * accessor for created_at
     * @param mixed $value
     * @return string
     */
    protected function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    // _____________________________
    // _____________________________

    /**
     * Model Belongs To Vendor Model.
     * @return BelongsTo<Vendor, VendorReview>
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Model Belongs To User Model.
     * @return BelongsTo<User, VendorReview>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

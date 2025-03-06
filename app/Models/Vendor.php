<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // _____________________________
    // _____________________________


    /**
     * Model Mayhave Multiple Reviews
     * @return HasMany<VendorReview, Vendor>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(VendorReview::class);
    }


    /**
     * Model belongs to VendorCategory Model.
     * @return BelongsTo<VendorCategory, Vendor>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(VendorCategory::class);
    }


    /**
     * Model Belongs To Busigness Model.
     * @return BelongsTo<Business, Vendor>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}

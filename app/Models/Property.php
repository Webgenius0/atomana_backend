<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
            'id'                 => 'integer',
            'business_id'        => 'integer',
            'agent'              => 'integer',
            'price'              => 'float',
            'co_agent'           => 'integer',
            'co_list_percentage' => 'float',
            'development'        => 'boolean',
            'created_at'         => 'datetime',
            'updated_at'         => 'datetime',
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

    /**
     *  acccessor for CoListPercentage Attribute
     * @param mixed $value
     * @return string
     */
    protected function getCoListPercentageAttribute($value): string
    {
        return  number_format($value, 2, '.', '');
    }

    // ------------------------------------
    // ------------------------------------

    /**
     * belong to an User Model
     * @return BelongsTo<User, Property>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent');
    }


    /**
     * belong to an User Model
     * @return BelongsTo<User, Property>
     */
    public function coAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'co_agent');
    }

    /**
     * belongs to Property Model.
     * @return BelongsTo<Business, Property>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Model may have one SalesTrack
     * @return HasOne<SalesTrack, User>
     */
    public function SalesTrack(): HasOne
    {
        return $this->hasOne(SalesTrack::class);
    }

    /**
     * Model may have many OpenHouse
     * @return HasMany<OpenHouse, Property>
     */
    public function openHouses():HasMany
    {
        return $this->hasMany(OpenHouse::class);
    }
}

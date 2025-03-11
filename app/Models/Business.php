<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
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


    // ------------------------------------
    // ------------------------------------

    /**
     * Business can have multiple users.
     * Getting all user of the Business.
     *
     * @return BelongsToMany<User, Business>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * relstion with Proerty Model.
     * @return HasMany<Property, User>
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Model may have multipel SalesTrack
     * @return HasMany<SalesTrack, User>
     */
    public function SalesTrack(): HasMany
    {
        return $this->hasMany(SalesTrack::class);
    }

    /**
     * Model may have many OpenHouse
     * @return HasMany<OpenHouse, Property>
     */
    public function openHouses(): HasMany
    {
        return $this->hasMany(OpenHouse::class);
    }

    /**
     * Model may have multiple vendorCategory
     * @return HasMany<VendorCategory, Business>
     */
    public function vendorCategories():HasMany
    {
        return $this->hasMany(VendorCategory::class);
    }

    /**
     * Model may have multipe vendors
     * @return HasMany<Vendor, Business>
     */
    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * owner
     * @return \Illuminate\Support\Collection<int|string, mixed>
     */
    public function owner()
    {
        return $this->users()->where('role_id', 2)->pluck('user_id');
    }
}

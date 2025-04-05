<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public function vendorCategories(): HasMany
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
     * model may have many tiers
     * @return HasMany<Tier, Business>
     */
    public function tiers():HasMany
    {
        return $this->hasMany(Tier::class);
    }

    /**
     * owner
     * @return \Illuminate\Support\Collection<int|string, mixed>
     */
    public function owner()
    {
        return $this->users()->where('role_id', 2)->pluck('user_id');
    }

    /**
     * A business may have many password lists associated with it.
     *
     * @return HasMany<PasswordList, Business>
     */

    public function passwordLists(): HasMany
    {
        return $this->hasMany(PasswordList::class);
    }

    /**
     * Model may have multiple shared notes
     * @return HasMany<SharedNote, Business>
     */

    public function sharedNotes(): HasMany
    {
        return $this->hasMany(SharedNote::class);
    }

    /**
     * has many agentEarning
     * @return HasMany<AgentEarningView, Business>
     */
    public function agentEarnings():HasMany
    {
        return $this->hasMany(AgentEarningView::class);
    }

    /**
     * has one businessInfo
     * @return HasOne<BusinessInfoView, Business>
     */
    public function businessInfo():HasOne
    {
        return $this->hasOne(BusinessInfoView::class);
    }

    /**
     * openHouseFeedback
     * @return HasMany<OpeHouseFeedback, User>
     */
    public function openHouseFeedback() : HasMany
    {
        return $this->hasMany(OpeHouseFeedback::class);
    }
}

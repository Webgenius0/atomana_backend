<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpenHouseFeedback extends Model
{
    protected $table = "open_house_feedbacks";
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
            'id'            => 'integer',
            'user_id'       => 'integer',
            'business_id'   => 'integer',
            'property_id'   => 'integer',
            'open_house_id' => 'integer',
            'people_count'  => 'integer',
            'created_at'    => 'datetime',
            'updated_at'    => 'datetime',
        ];
    }


    // ------------------------------------
    // ------------------------------------

    /**
     *  user
     * @return BelongsTo<User, OpenHouseFeedback>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * business
     * @return BelongsTo<Business, OpenHouseFeedback>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * property
     * @return BelongsTo<Property, OpenHouseFeedback>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * openHouse
     * @return BelongsTo<OpenHouse, OpenHouseFeedback>
     */
    public function openHouse(): BelongsTo
    {
        return $this->belongsTo(OpenHouse::class);
    }
}

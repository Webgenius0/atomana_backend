<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpenHouse extends Model
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
            'id'          => 'integer',
            'business_id' => 'integer',
            'property_id' => 'integer',
            'date'        => 'date',
            'start_time'  => 'datetime',
            'end_time'    => 'datetime',
            'wavy_man'    => 'boolean',
            'sign_number' => 'integer',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
        ];
    }


    // accessor for `date`
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    // accessor for `start_time`
    public function getStartTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    // accessor for `end_time`
    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }


    // _____________________________
    // _____________________________

    /**
     * belongs to Property Model.
     * @return BelongsTo<Business, Property>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * belongs to Property Model.
     * @return BelongsTo<Property, OpenHouse>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}

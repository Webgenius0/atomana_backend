<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesTrack extends Model
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

    /**
     * acccessor for Price Attribute
     * @param mixed $value
     * @return string
     */
    protected function getPriceAttribute($value):string
    {
        return number_format($value, 2, '.', '');
    }

    // ------------------------------------
    // ------------------------------------

    /**
     * Model belongs to User Model.
     * @return BelongsTo<User, SalesTrack>
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Model belongs to Business Model.
     * @return BelongsTo<Business, SalesTrack>
     */
    public function business():BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Model belongs to Property Model.
     * @return BelongsTo<Property, SalesTrack>
     */
    public function property():BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

}

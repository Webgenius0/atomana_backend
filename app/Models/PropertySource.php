<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertySource extends Model
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
            'id'                 => 'integer',
            'created_at'         => 'datetime',
            'updated_at'         => 'datetime',
        ];
    }

    // ------------------------------------
    // ------------------------------------


    /**
     * model has many properties
     * @return HasMany<Property, PropertySource>
     */
    public function properties():HasMany
    {
        return $this->hasMany(Property::class);
    }
}

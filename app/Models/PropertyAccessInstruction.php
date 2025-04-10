<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAccessInstruction extends Model
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
            'id'               => 'integer',
            'property_id'      => 'integer',
            'property_type_id' => 'integer',
        ];
    }

    //------------------------------------
    //------------------------------------


    /**
     * property
     * @return BelongsTo<Property, PropertyAccessInstruction>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * propertyType
     * @return BelongsTo<PropertyType, PropertyAccessInstruction>
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class, );
    }
}

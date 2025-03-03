<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            'start_time'  => 'time',
            'end_time'    => 'time',
            'wavy_nam'    => 'boolean',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
        ];
    }

}

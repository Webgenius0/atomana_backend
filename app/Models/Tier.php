<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tier extends Model
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
            'id'          => 'integer',
            'business_id' => 'integer',
            'from'        => 'float',
            'to'          => 'float',
            'cut'         => 'float',
            'diduct'      => 'float',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
        ];
    }
    // _____________________________
    // _____________________________

    /**
     * belongs to business
     * @return BelongsTo<Business, Tier>
     */
    public function business():BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MyPR extends Model
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
     * Summary of messages
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<MyPRMessage, MyPR>
     */
    public function messages():HasMany
    {
        return $this->hasMany(MyPRMessage::class);
    }
}
